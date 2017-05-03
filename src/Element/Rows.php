<?php

namespace Joomla\Content\Element;

use Joomla\Content\ContentElementInterface;

/**
 * Class Rows
 *
 * This element is a container for rows, i.e., (block) elements arranged vertically.
 *
 * @package Joomla\Content\Element
 */
class Rows extends AbstractCompositeElement
{
    /**
     * The child elements
     *
     * @var ContentElementInterface[]
     */
    protected $elements;

    /**
     * The expected class of child elements
     *
     * @var string
     */
    protected $elementType = ContentElementInterface::class;

    /**
     * Rows constructor.
     *
     * @param ContentElementInterface[] $elements The rows
     * @param array $params The presentation parameters
     */
    public function __construct($elements = [], $params = [])
    {
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
        return new static([$data], $params);
    }
}
