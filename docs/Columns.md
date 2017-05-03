[◄ Back to index](index.md)
# Joomla\Content\Element\Columns

This element is a container for columns, i.e., (block) elements arranged horizontally.

## Usage

```php
$columns = new Columns( [ ContentElementInterface[] $elements [, array $params ] ] );
```

or

```php
$columns = Columns::from( ContentElementInterface $data [, array $mapping [, array $params ] ] );
```



## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
elements | ContentElementInterface[] | The child elements | -

#### Elements

Get the child elements.



```php
$elements = $columns->getElements();
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
$params = $columns->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $columns->getParameter( 'id' [, $default ] );
$class = $columns->getParameter( 'class' [, $default ] );
```

## Examples

