#!/usr/bin/php
<?php
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\DocBlockFactory;

$baseDir = dirname(__DIR__);

require_once $baseDir . '/vendor/autoload.php';

class ClassAccessor
{
    /** @var  DocBlockFactory */
    protected $factory;

    /** @var  string */
    protected $className;

    /** @var  ReflectionClass */
    protected $reflector;

    public function __construct($className, DocBlockFactory $factory)
    {
        $this->className = $className;
        $this->factory = $factory;

        $this->reflector = new ReflectionClass($className);
    }

    /**
     * @return \phpDocumentor\Reflection\DocBlock
     */
    public function getClassDocBlock()
    {
        return $this->factory->create($this->reflector->getDocComment());
    }

    /**
     * @return ReflectionParameter[]
     */
    public function getConstructorArgs()
    {
        $args = $this->reflector->getConstructor()->getParameters();
        $tags = $this->getConstructorDocBlock()->getTagsByName('param');

        return $this->processMethodArgs($args, $tags);
    }

    /**
     * @return \phpDocumentor\Reflection\DocBlock
     */
    public function getConstructorDocBlock()
    {
        return $this->factory->create($this->reflector->getConstructor()->getDocComment());
    }

    /**
     * @param ReflectionParameter[] $args
     * @param Tag[] $tags
     *
     * @return array
     */
    protected function processMethodArgs($args, $tags)
    {
        $properties = $this->getProperties();

        $methodArgs = [];
        foreach ($args as $arg) {
            $tag = array_shift($tags);

            $type = $arg->getType();
            $name = $arg->getName();
            $summary = "The $name";
            $description = '';

            if (preg_match('~@param\s+(\S+)\s+\$(\S+)(?:\s+(.*?))?(?:\n\s*(.*))?$~sm', $tag->render(), $parts)) {
                $type = empty($type) ? $parts[1] : $type;
                $name = $parts[2];
                $summary = isset($parts[3]) ? $parts[3] : "The $name";
                $description = isset($parts[4]) ? $parts[4] : '';
            }
            $type = preg_replace('~^.*\\\~', '', $type);
            $required = !$arg->isOptional();

            if (!array_key_exists($name, $properties)) {
                $properties[$name] = [
                    'summary' => $summary,
                    'description' => $description,
                ];
            }

            $methodArgs[$name] = [
                'type' => preg_replace('~^.*\\\~', '', $type),
                'name' => $name,
                'summary' => empty($properties[$name]['summary']) ? $summary : $properties[$name]['summary'],
                'description' => empty($properties[$name]['description']) ? $description : $properties[$name]['description'],
                'required' => $required,
            ];
        }
        return $methodArgs;
    }

    public function getProperties()
    {
        $properties = [];
        foreach ($this->reflector->getProperties() as $property) {
            if ($property->isPrivate()) {
                continue;
            }

            $docBlock = $this->factory->create($property->getDocComment());
            $varTags = $docBlock->getTagsByName('var');

            $type = null;
            if (count($varTags) > 0) {
                $varTag = array_shift($varTags);
                $type = preg_replace('~^@var\s+(\S+).*$~', '\\1', $varTag->render());
            }

            $properties[$property->getName()] = [
                'type' => $type,
                'name' => $property->getName(),
                'summary' => $docBlock->getSummary(),
                'description' => $docBlock->getDescription(),
            ];
        }

        return $properties;
    }

    /**
     * @param string $method
     * @return ReflectionParameter[]
     */
    public function getMethodArgs($method)
    {
        $args = $this->reflector->getMethod($method)->getParameters();
        $tags = $this->getMethodDocBlock($method)->getTagsByName('param');

        return $this->processMethodArgs($args, $tags);
    }

    /**
     * @param string $method
     * @return \phpDocumentor\Reflection\DocBlock
     */
    public function getMethodDocBlock($method)
    {
        return $this->factory->create($this->reflector->getMethod($method)->getDocComment());
    }
}

class DocGenerator
{
    public function process($sourceDirectory, $docsDirectory)
    {
        $factory = DocBlockFactory::createInstance();
        foreach (glob($sourceDirectory . '*.php') as $file) {
            $elementName = basename($file, '.php');

            if (preg_match('~Abstract~', $elementName)) {
                continue;
            }

            $namespace = preg_replace('~^.*namespace\s+([^;]+).*$~sm', '\1', file_get_contents($file));

            $className = $namespace . '\\' . $elementName;

            $classAccessor = new ClassAccessor($className, $factory);
            $classDocBlock = $classAccessor->getClassDocBlock();
            $constructorArgs = $classAccessor->getConstructorArgs();
            $fromMethodArgs = $classAccessor->getMethodArgs('from');

            $classDescription = $classDocBlock->getDescription();

            $var = lcfirst($elementName);

            $args = '';
            $last = '';
            $properties = [];
            $required = [];
            $propertyUsage = [];

            foreach ($constructorArgs as $arg) {
                $type = str_replace('Joomla\\Content\\', '', $arg['type']);
                $name = $arg['name'];
                $summary = $arg['summary'];
                $description = $arg['description'];

                $typedArg = " $type \$$name";
                if (!empty($args)) {
                    $typedArg = ',' . $typedArg;
                }
                if ($arg['required'] == false) {
                    $typedArg = ' [' . $typedArg;
                    $last .= ' ]';
                } else {
                    $required[] = $name;
                }

                $args .= $typedArg;

                if ($name == 'params') {
                    continue;
                }

                $properties[] = implode(' | ', [
                    'name' => $name,
                    'type' => $type,
                    'description' => empty($summary) ? preg_replace('~\.\s+.*~', '', $description) : $summary,
                    'required' => $arg['required'] ? 'yes' : '-',
                ]);

                if ($name == 'elements') {
                    $headline = "\n#### " . ucfirst($name) . "\n\nGet " . rtrim(lcfirst($summary), '.') . ".\n";
                    if (!empty($description)) {
                        $headline .= "\n{$description}\n";
                    }
                    $propertyUsage[] = "{$headline}\n```php\n\${$name} = \${$var}->getElements();\n```";

                    continue;
                }

                $default = '';
                if ($arg['required'] == false) {
                    $default = "[, \$default ] ";
                }
                $headline = "\n#### " . ucfirst($name) . "\n\nGet " . rtrim(lcfirst($summary), '.') . ".\n";
                if (!empty($description)) {
                    $headline .= "\n{$description}\n";
                }
                $propertyUsage[] = "{$headline}\n```php\n\${$name} = \${$var}->get( '{$name}' {$default});\n```";
            }
            $args .= $last;
            $args = trim($args);

            $req = '';
            $firstArg = reset($fromMethodArgs);
            $orParams = '';
            if ($firstArg['type'] != 'array|object') {
                array_shift($required);
                $orParams = ' or `params`';
            }
            if (!empty($required)) {
                $req = "`{$firstArg['name']}`{$orParams} must contain values for the required constructor argument";
                if (count($required) > 1) {
                    $last = array_pop($required);
                    $req .= 's `';
                    $req .= implode('`, `', $required);
                    $req .= '` and `' . $last . '`.';
                } else {
                    $req .= ' `' . $required[0] . '`.';
                }
            }

            $replace = [
                '%ICON%' => $this->getIcon($elementName),
                '%NAMESPACE%' => $namespace,
                '%CLASS%' => $elementName,
                '%VARNAME%' => $var,
                '%SUMMARY%' => sprintf('%s', (string)$classDescription),
                '%PROPERTIES%' => implode("\n", $properties) . "\n" . implode("\n", $propertyUsage),
                '%CONSTRUCTOR%' => "\$$var = new $elementName( $args );",
                '%FROMDATA%' => "\$$var = $elementName::from( {$fromMethodArgs['data']['type']} \${$fromMethodArgs['data']['name']} [, array \$mapping [, array \$params ] ] );",
                '%REQUIRED%' => $req,
                '%EXAMPLES%' => '',
            ];

            $template = <<<MD
[◄ Back to index](index.md)
# %ICON% %NAMESPACE%\%CLASS%

%SUMMARY%

## Usage

```php
%CONSTRUCTOR%
```

or

```php
%FROMDATA%
```

%REQUIRED%

## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
%PROPERTIES%

## Parameters

Parameters are optional settings for the presentation.
All elements can have 'id' and 'class' parameters; other depend on environment 
and/or renderer.

Parameter | Type   | Description
--------- | ------ | -----------
id        | string | The ID of the element
class     | string | CSS class

#### Parameter List

Get an associative array with all parameters.

```php
\$params = \$%VARNAME%->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
\$id    = \$%VARNAME%->getParameter( 'id' [, \$default ] );
\$class = \$%VARNAME%->getParameter( 'class' [, \$default ] );
```

## Examples

%EXAMPLES%
MD;

            $template = str_replace(array_keys($replace), array_values($replace), $template);

            file_put_contents($docsDirectory . $elementName . '.md', $template);
        }
    }

    /**
     * @param string $elementName The name of the element
     *
     * @return string
     */
    private function getIcon($elementName)
    {
        $assetDirectory = 'docs/assets/';
        $iconName = lcfirst($elementName);
        if (!file_exists($assetDirectory . $iconName . '-32x32.png'))
        {
            $iconName = 'undefined';
        }

        $icon = "![{$elementName} icon](assets/{$iconName}-32x32.png)";

        return $icon;
    }
}

$generator = new DocGenerator();
$generator->process($baseDir . '/src/Element/', $baseDir . '/docs/');
