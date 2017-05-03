<?php

namespace Joomla\Content\Element;

/**
 * Class Tabs
 *
 * A tabbed document interface (TDI) or Tab is a graphical control element that allows multiple documents or panels to
 * be contained within a single window, using tabs as a navigational widget for switching between sets of documents.
 * It is an interface style most commonly associated with web browsers, web applications, text editors, and preference
 * panes.
 *
 * GUI tabs are modeled after traditional card tabs inserted in paper files or card indexes (in keeping with the desktop
 * metaphor).
 *
 * _From [Wikipedia](https://en.wikipedia.org/wiki/Tab_(GUI))_
 *
 * @package Joomla\Content\Element
 */
class Tabs extends AbstractCompositeElement
{
    /**
     * Tabs constructor.
     *
     * @param Panel[] $elements The panels of the tabs
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
        self::checkType($data, Panel::class);

        return new static([$data], $params);
    }
}
