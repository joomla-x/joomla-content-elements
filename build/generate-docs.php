#!/usr/bin/php
<?php
use phpDocumentor\Reflection\DocBlockFactory;

$baseDir = dirname(__DIR__);

require_once $baseDir . '/vendor/autoload.php';

$template = <<<MD

# %NAMESPACE%\%CLASS%

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

$sourceDirectory = $baseDir . '/src/Element/';

$factory = DocBlockFactory::createInstance();
foreach (glob($sourceDirectory .'*.php') as $file)
{
    $elementName = basename($file, '.php');

    if ($elementName == 'AbstractElement')
    {
        continue;
    }

    $namespace = preg_replace('~^.*namespace\s+([^;]+).*$~sm', '\1', file_get_contents($file));

    $className = $namespace . '\\' . $elementName;
    $reflector = new ReflectionClass($className);
    $classDocBlock = $factory->create($reflector->getDocComment());

    $constructor = $reflector->getConstructor();
    $ctorDocBlock = $factory->create($constructor->getDocComment());

    $constructorArgs = $constructor->getParameters();
    $paramsArg = array_pop($constructorArgs);



    $classSummary = $classDocBlock->getSummary();

    $classDescription = $classDocBlock->getDescription();

    $ctorSummary = $ctorDocBlock->getSummary();

    $ctorDescription = $ctorDocBlock->getDescription();

    $tags = $ctorDocBlock->getTagsByName('param');

    $var = lcfirst($elementName);

    $args = '';
    $last = '';
    $properties = [];
    $required = [];
    $propertyUsage = [];

    foreach ($constructorArgs as $arg)
    {
        $tag = array_shift($tags);

        $description = $tag->render();
        if (preg_match('~@param\s+(\w+)\s+\$(\w+)\s+(.*)$~', $description, $parts))
        {
            $type = $parts[1];
            $name = $parts[2];
            $description = $parts[3];
        }
        else
        {
            $type = $arg->getType();
            $name = $arg->getName();
            $description = "The $name";
        }

        $typedArg = "$type \$$name";
        if (!empty($args))
        {
            $typedArg = ', ' . $typedArg;
        }
        if ($arg->isOptional())
        {
            $typedArg = ' [' . $typedArg;
            $last .= ' ]';
        }
        else
        {
            $required[] = $name;
        }

        $args .= $typedArg;

        $properties[] = implode(' | ', [
            'name' => $name,
            'type' => $type,
            'description' => $description,
            'required' => $arg->isOptional() ? '-' : 'yes',
        ]);

        $default = '';
        if ($arg->isOptional())
        {
            $default = "[, \$default ] ";
        }
        $headline = "\n#### " . ucfirst($name) . "\n\nGet " . lcfirst($description) . ".\n";
        $propertyUsage[] = "{$headline}\n```php\n\${$name} = \${$var}->get( '{$name}' {$default});\n```";
    }
    $args .= " [, array \$params $last ]";

    $req = '';
    if (!empty($required))
    {
        $req = "`data` must contain values for the required constructor argument";
        if (count($required) > 1) {
            $last = array_pop($required);
            $req .= 's `';
            $req .= implode('`, `', $required);
            $req .= '` and `' . $last . '`.';
        } else {
            $req = ' `' . $required[0] . '`.';
        }
    }

    $replace = [
        '%NAMESPACE%' => $namespace,
        '%CLASS%' => $elementName,
        '%VARNAME%' => $var,
        '%SUMMARY%' => sprintf('%s', (string) $classDescription),
        '%PROPERTIES%' => implode("\n", $properties) . "\n" . implode("\n", $propertyUsage),
        '%CONSTRUCTOR%' => "\$$var = new $elementName( $args );",
        '%FROMDATA%' => "\$$var = $elementName::from( array|object \$data [, array \$mapping [, array \$params ] ] );",
        '%REQUIRED%' => $req,
        '%EXAMPLES%' => '',
    ];

    $template = str_replace(array_keys($replace), array_values($replace), $template);

    file_put_contents($baseDir . '/docs/' . $elementName . '.md', $template);
}
