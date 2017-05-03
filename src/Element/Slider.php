<?php

namespace Joomla\Content\Element;

/**
 * Class Slider
 *
 * In web design terminology, the term Slider is used for a slide show added into a web page.
 * Sliders can be used on all kind of websites however they’re most commonly used on business websites or professional
 * portfolio websites. One clear advantage of using a slider is that website owners can place all their important
 * content in a visually appealing and interactive slide show at the top of the page before their main content. This
 * allows users to quickly see the highlights and take action.
 *
 * Sliders can run slide shows automatically without user input by moving slides on pre-defined time interval. Sliders
 * can also respond to user interaction like click or swipe to view next or previous slides. Additionally, sliders can
 * also have buttons or thumbnails which users can click to view a particular slide in the slider.
 *
 * _From [wpbeginner.com](http://www.wpbeginner.com/glossary/slider/)_
 *
 * @package Joomla\Content\Element
 */
class Slider extends AbstractCompositeElement
{
    /**
     * The child elements
     *
     * @var Panel[]
     */
    protected $elements;

    /**
     * The expected class of child elements
     *
     * @var string
     */
    protected $elementType = Panel::class;

    /**
     * Slider constructor.
     *
     * @param Panel[] $elements The panels of the slider
     * @param array $params The presentation parameters
     */
    public function __construct($elements = [], $params = [])
    {
        $this->init($elements, $params);
    }

    /**
     * Create an element.
     *
     * @param Panel $data The element to be wrapped
     * @param array $mapping The property mapping
     * @param array $params The presentation parameters
     *
     * @return self
     */
    public static function from($data, $mapping = [], $params = [])
    {
        return new static([$data], $params);
    }
}
