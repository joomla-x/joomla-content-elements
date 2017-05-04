[◄ Back to index](index.md)
# ![Rows icon](docs/assets/undefined.svg) Joomla\Content\Element\Rows

This element is a container for rows, i.e., (block) elements arranged vertically.

## Usage

```php
$rows = new Rows( [ ContentElementInterface[] $elements [, array $params ] ] );
```

or

```php
$rows = Rows::from( ContentElementInterface $data [, array $mapping [, array $params ] ] );
```



## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
elements | ContentElementInterface[] | The child elements | -

#### Elements

Get the child elements.



```php
$elements = $rows->getElements();
```

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
$params = $rows->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $rows->getParameter( 'id' [, $default ] );
$class = $rows->getParameter( 'class' [, $default ] );
```

## Examples

