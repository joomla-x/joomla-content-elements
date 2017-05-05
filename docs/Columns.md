[◄ Back to index](index.md)
# ![Columns icon](assets/undefined-32x32.png) Joomla\Content\Element\Columns

This element is a container for columns, i.e., (block) elements arranged horizontally.

## Usage

```php
$columnsElement = new Columns( [ ContentElementInterface[] $elements [, array $params ] ] );
```

or

```php
$columnsElement = Columns::from( ContentElementInterface $data [, array $mapping [, array $params ] ] );
```



## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
elements | ContentElementInterface[] | The child elements | -

#### Elements

Get the child elements.



```php
$elements = $columnsElement->getElements();
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
$params = $columnsElement->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $columnsElement->getParameter( 'id' [, $default ] );
$class = $columnsElement->getParameter( 'class' [, $default ] );
```

## Examples

