<?php

namespace Joomla\Content\Element;

use Joomla\Content\ContentElementInterface;

/**
 * Class Panel
 *
 * A panel is a particular arrangement of information grouped together for presentation to users in a window or pop-up.
 *
 * _From [Wikipedia](https://en.wikipedia.org/wiki/Panel_(computer_software))_
 *
 * Panels are used to add a title to a group of elements for use in collections, like [Accordion](Accordion.md) or
 * [Tabs](Tabs.md).
 *
 * @package Joomla\Content\Element
 */
class Panel extends AbstractCompositeElement
{
    /**
     * The title for the panel.
     *
     * @var string
     */
    protected $title;

    /**
     * Panel constructor.
     *
     * @param ContentElementInterface[] $elements The elements to be wrapped
     * @param string $title The title
     * @param array $params The presentation parameters
     */
    public function __construct($elements, $title, $params = [])
    {
        $this->title = $title;

        $this->init($elements, $params);
    }

    /**
     * Create an element.
     *
     * @param ContentElementInterface $data The element to be wrapped
     * @param array $mapping The property mapping
     * @param array $params The presentation parameters
     *
     * @return self
     */
    public static function from($data, $mapping = [], $params = [])
    {
        $title = self::findValueFor('title', $data, $mapping, $params);

        return new static([$data], $title, $params);
    }
}
