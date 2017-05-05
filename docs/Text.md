[◄ Back to index](index.md)
# ![Text icon](assets/text-32x32.png) Joomla\Content\Element\Text

Text (also body in journalism jargon) is a sequence of subheads, paragraphs and images.

## Usage

```php
$textElement = new Text( string $text [, array $params ] );
```

or

```php
$textElement = Text::from( array|object $data [, array $mapping [, array $params ] ] );
```

`data` must contain values for the required constructor argument `text`.

## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
text | string | The text | yes

#### Text

Get the text.



```php
$text = $textElement->get( 'text' );
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
$params = $textElement->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $textElement->getParameter( 'id' [, $default ] );
$class = $textElement->getParameter( 'class' [, $default ] );
```

## Examples

