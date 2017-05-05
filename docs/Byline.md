[◄ Back to index](index.md)
# ![Byline icon](assets/undefined-32x32.png) Joomla\Content\Element\Byline

The byline on a newspaper or magazine article gives the date, as well as the name of the writer of the article.
Bylines are commonly placed between the headline and the text of the article, although some magazines (notably
Reader's Digest) place bylines at the bottom of the page to leave more room for graphical elements around the
headline.

The dictionary defines a byline as "a printed line of text accompanying a news story, article, or the like, giving
the author's name."

_From [Wikipedia](https://en.wikipedia.org/wiki/Byline)_

## Usage

```php
$byline = new Byline( [ DateTime $date [, string $author [, string $position [, array $params ] ] ] ] );
```

or

```php
$byline = Byline::from( array|object $data [, array $mapping [, array $params ] ] );
```



## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
date | DateTime | The date of writing | -
author | string | The name of the author | -
position | string | The position of the author | -

#### Date

Get the date of writing.



```php
$date = $byline->get( 'date' [, $default ] );
```

#### Author

Get the name of the author.



```php
$author = $byline->get( 'author' [, $default ] );
```

#### Position

Get the position of the author.



```php
$position = $byline->get( 'position' [, $default ] );
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
$params = $byline->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $byline->getParameter( 'id' [, $default ] );
$class = $byline->getParameter( 'class' [, $default ] );
```

## Examples

