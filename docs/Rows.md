[◄ Back to index](index.md)
# ![Rows icon](assets/undefined-32x32.png) Joomla\Content\Element\Rows

This element is a container for rows, i.e., (block) elements arranged vertically.

## Usage

```php
$rowsElement = new Rows( [ ContentElementInterface[] $elements [, array $params ] ] );
```

or

```php
$rowsElement = Rows::from( ContentElementInterface $data [, array $mapping [, array $params ] ] );
```



## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
elements | ContentElementInterface[] | The child elements | -

#### Elements

Get the child elements.



```php
$elements = $rowsElement->getElements();
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
$params = $rowsElement->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $rowsElement->getParameter( 'id' [, $default ] );
$class = $rowsElement->getParameter( 'class' [, $default ] );
```

## Examples

