[◄ Back to index](index.md)
# ![Tabs icon](assets/tabs-32x32.png) Joomla\Content\Element\Tabs

A tabbed document interface (TDI) or Tab is a graphical control element that allows multiple documents or panels to
be contained within a single window, using tabs as a navigational widget for switching between sets of documents.
It is an interface style most commonly associated with web browsers, web applications, text editors, and preference
panes.

GUI tabs are modeled after traditional card tabs inserted in paper files or card indexes (in keeping with the desktop
metaphor).

_From [Wikipedia](https://en.wikipedia.org/wiki/Tab_(GUI))_

## Usage

```php
$tabs = new Tabs( [ Panel[] $elements [, array $params ] ] );
```

or

```php
$tabs = Tabs::from( Panel $data [, array $mapping [, array $params ] ] );
```



## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
elements | Panel[] | The child elements | -

#### Elements

Get the child elements.



```php
$elements = $tabs->getElements();
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
$params = $tabs->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $tabs->getParameter( 'id' [, $default ] );
$class = $tabs->getParameter( 'class' [, $default ] );
```

## Examples

