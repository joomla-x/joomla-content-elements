
# Joomla\Content\Element\Headline



## Usage

```php
$headline = new Headline( string $text [, int $level [, array $params  ] ] );
```

or

```php
$headline = Headline::from( array|object $data [, array $mapping [, array $params ] ] );
```

 `text`.

## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
text | string | The text for the headline | yes
level | int | The level of the headline, defaults to 1 | -

#### Text

Get the text for the headline.

```php
$text = $headline->get( 'text' );
```

#### Level

Get the level of the headline, defaults to 1.

```php
$level = $headline->get( 'level' [, $default ] );
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
$params = $headline->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $headline->getParameter( 'id' [, $default ] );
$class = $headline->getParameter( 'class' [, $default ] );
```

## Examples

