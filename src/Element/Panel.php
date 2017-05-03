<?php

namespace Joomla\Content\Element;

use Joomla\Content\ContentElementInterface;

/**
 * Class Panel
 *
 * The purpose of this element is to add a title to an element for use in collections, like accordions or tabs.
 *
 * @package Joomla\Content\Element
 */
class Panel extends AbstractCompositeElement
{
    /**
     * The title for the wrapped element.
     *
     * @var string
     */
    protected $title;

    /**
     * Panel constructor.
     *
     * @param ContentElementInterface[] $elements The element to be wrapped
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
        self::checkType($data);

        $title = self::findValueFor('title', $data, $mapping, $params);

        return new static([$data], $title, $params);
    }
}
