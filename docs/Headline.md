[◄ Back to index](index.md)
# ![Headline icon](assets/undefined-32x32.png) Joomla\Content\Element\Headline

The headline (also heading, head or title, or hed in journalism jargon) of a story is typically a complete sentence
(e.g., "Pilot Flies Below Bridges to Save Divers"), often with auxiliary verbs and articles removed (e.g., "Remains
at Colorado camp linked to missing Chicago man"). However, headlines sometimes omit the subject (e.g., "Jumps From
Boat, Catches in Wheel") or verb (e.g., "Cat woman lucky").

_From [Wikipedia](https://en.wikipedia.org/wiki/News_style#Headline)_

_See also:_

[Glossary of Journalism](https://en.wiktionary.org/wiki/Appendix:Glossary_of_journalism#Article_components) on Wiktionary

## Usage

```php
$headlineElement = new Headline( string $text [, int $level [, array $params ] ] );
```

or

```php
$headlineElement = Headline::from( array|object $data [, array $mapping [, array $params ] ] );
```

`data` must contain values for the required constructor argument `text`.

## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
text | string | The text for the headline | yes
level | int | The level of the headline | -

#### Text

Get the text for the headline.



```php
$text = $headlineElement->get( 'text' );
```

#### Level

Get the level of the headline.



```php
$level = $headlineElement->get( 'level' [, $default ] );
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
$params = $headlineElement->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $headlineElement->getParameter( 'id' [, $default ] );
$class = $headlineElement->getParameter( 'class' [, $default ] );
```

## Examples

