[◄ Back to index](index.md)
# ![Slider icon](docs/assets/slider.svg) Joomla\Content\Element\Slider

In web design terminology, the term Slider is used for a slide show added into a web page.
Sliders can be used on all kind of websites however they’re most commonly used on business websites or professional
portfolio websites. One clear advantage of using a slider is that website owners can place all their important
content in a visually appealing and interactive slide show at the top of the page before their main content. This
allows users to quickly see the highlights and take action.

Sliders can run slide shows automatically without user input by moving slides on pre-defined time interval. Sliders
can also respond to user interaction like click or swipe to view next or previous slides. Additionally, sliders can
also have buttons or thumbnails which users can click to view a particular slide in the slider.

_From [wpbeginner.com](http://www.wpbeginner.com/glossary/slider/)_

## Usage

```php
$slider = new Slider( [ Panel[] $elements [, array $params ] ] );
```

or

```php
$slider = Slider::from( Panel $data [, array $mapping [, array $params ] ] );
```



## Properties

Property | Type   | Description  | Required
-------- | ------ | ------------ | ----
elements | Panel[] | The child elements | -

#### Elements

Get the child elements.



```php
$elements = $slider->getElements();
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
$params = $slider->getParameters();
```

#### Single Parameter

Retrieve a single parameter. Default should be provided.

```php
$id    = $slider->getParameter( 'id' [, $default ] );
$class = $slider->getParameter( 'class' [, $default ] );
```

## Examples

