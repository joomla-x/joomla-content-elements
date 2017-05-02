
# Joomla\Content\Element\TitledElement

The purpose of this element is to add a title to an element for use in collections, like accordions or tabs.

## Usage

```php
$titledElement = new TitledElement( Joomla\Content\ContentElementInterface $element, string $title [, array $params  ] );
```

or

```php
$titledElement = TitledElement::from( array|object $data [, array $mapping [, array $params ] ] );
```

`data` must contain values for the required constructor arguments `element` and `title`.

## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
element | Joomla\Content\ContentElementInterface | The element | yes
title | string | The title for the wrapped element | yes

#### Element

Get the element.

```php
$element = $titledElement->get( 'element' );
```

#### Title

Get the title for the wrapped element. This title is not necessarily the same as the title of the element.

```php
$title = $titledElement->get( 'title' );
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
$params = $titledElement->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $titledElement->getParameter( 'id' [, $default ] );
$class = $titledElement->getParameter( 'class' [, $default ] );
```

## Examples

