
# Joomla\Content\Element\Panel

The purpose of this element is to add a title to an element for use in collections, like accordions or tabs.

## Usage

```php
$panel = new Panel( ContentElementInterface[] $elements, string $title [, array $params ] );
```

or

```php
$panel = Panel::from( ContentElementInterface $data [, array $mapping [, array $params ] ] );
```

`data` or `params` must contain values for the required constructor argument `title`.

## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
elements | ContentElementInterface[] | The child elements | yes
title | string | The title for the wrapped element. | yes

#### Elements

Get the child elements.



```php
$elements = $panel->getElements();
```

#### Title

Get the title for the wrapped element.



```php
$title = $panel->get( 'title' );
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
$params = $panel->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $panel->getParameter( 'id' [, $default ] );
$class = $panel->getParameter( 'class' [, $default ] );
```

## Examples
