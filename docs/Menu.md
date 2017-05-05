[◄ Back to index](index.md)
# ![Menu icon](assets/undefined-32x32.png) Joomla\Content\Element\Menu

A menu is a list of options or commands presented to the user of a computer or communications system. A menu may
either be a system's entire user interface, or only part of a more complex one.

A computer using a graphical user interface presents menus with a combination of text and symbols to represent
choices. By clicking on one of the symbols or text, the operator is selecting the instruction that the symbol
represents. A context menu is a menu in which the choices presented to the operator are automatically modified
according to the current context in which the operator is working.

A common use of menus is to provide convenient access to various operations such as saving or opening a file,
quitting a program, or manipulating data. Most widget toolkits provide some form of pull-down or pop-up menu.
Pull-down menus are the type commonly used in menu bars (usually near the top of a window or screen), which are
most often used for performing actions, whereas pop-up (or "fly-out") menus are more likely to be used for setting
a value, and might appear anywhere in a window.

_From [Wikipedia](https://en.wikipedia.org/wiki/Menu_(computing))_

## Usage

```php
$menuElement = new Menu( string $label, string $action [, string $icon [, Menu[] $elements [, array $params ] ] ] );
```

or

```php
$menuElement = Menu::from( array|object $data [, array $mapping [, array $params ] ] );
```

`data` must contain values for the required constructor arguments `label` and `action`.

## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
label | string | The label of the menu item | yes
action | string | The URL of the action | yes
icon | string | The name of the icon | -
elements | Menu[] | The child elements | -

#### Label

Get the label of the menu item.



```php
$label = $menuElement->get( 'label' );
```

#### Action

Get the URL of the action.



```php
$action = $menuElement->get( 'action' );
```

#### Icon

Get the name of the icon.



```php
$icon = $menuElement->get( 'icon' [, $default ] );
```

#### Elements

Get the child elements.



```php
$elements = $menuElement->getElements();
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
$params = $menuElement->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $menuElement->getParameter( 'id' [, $default ] );
$class = $menuElement->getParameter( 'class' [, $default ] );
```

## Examples

