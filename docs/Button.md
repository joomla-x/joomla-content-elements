
# Joomla\Content\Element\Button

A typical button is a rectangle or rounded rectangle, wider than it is tall, with a descriptive caption in its center.
The most common method of pressing a button is clicking it with a pointer controlled by a mouse, but other input such
as keystrokes can be used to execute the command of a button. A button is not however always restricted to a
rectangular shape. The sole requirement of button interaction is that the user can execute a command by a click
action. Thus pictures and background areas can be programmed as buttons. When pressed, in addition to performing a
predetermined task, buttons often undergo a graphical change to mimic a mechanical button being depressed.

A button often displays a tooltip when a user moves the pointer over it. The tooltip serves as built-in documentation
that briefly explains the purpose of the button.

Some very common incarnations of the button widget are:

- An OK button for confirming actions and closing the windows
- A Cancel button for canceling actions and closing the window
- An Apply button for confirming actions without closing the window
- A Close button for closing windows after changes have already been applied

_From [Wikipedia](https://en.wikipedia.org/wiki/Button_(computing))_

## Usage

```php
$button = new Button( string $label, string $url [, string $hint [, string $icon [, array $params ] ] ] );
```

or

```php
$button = Button::from( array|object $data [, array $mapping [, array $params ] ] );
```

`data` must contain values for the required constructor arguments `label` and `url`.

## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
label | string | The text on the button | yes
url | string | The link to the action | yes
hint | string | A hint about the action | -
icon | string | An optional icon name to represent the action | -

#### Label

Get the text on the button.



```php
$label = $button->get( 'label' );
```

#### Url

Get the link to the action.



```php
$url = $button->get( 'url' );
```

#### Hint

Get a hint about the action.



```php
$hint = $button->get( 'hint' [, $default ] );
```

#### Icon

Get an optional icon name to represent the action.



```php
$icon = $button->get( 'icon' [, $default ] );
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
$params = $button->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $button->getParameter( 'id' [, $default ] );
$class = $button->getParameter( 'class' [, $default ] );
```

## Examples

