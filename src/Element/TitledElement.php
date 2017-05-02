<?php

namespace Joomla\Content\Element;

use Joomla\Content\ContentElementInterface;

/**
 * Class TitledElement
 *
 * The purpose of this element is to add a title to an element for use in collections, like accordions or tabs.
 *
 * @package Joomla\Content\Element
 */
class TitledElement extends AbstractWrapper
{
    /**
     * @var array
     */
    protected $title;

    /**
     * TitledElement constructor.
     *
     * @param ContentElementInterface $element The element to be wrapped
     * @param string $title The title for the wrapped element. This title is not necessarily the same as the title of the element
     * @param array $params The presentation parameters
     */
    public function __construct(ContentElementInterface $element, $title, $params = [])
    {
        $this->title = $title;

        parent::__construct($element, $params);
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
        if (!$data instanceof ContentElementInterface) {
            $type = is_object($data) ? get_class($data) : gettype($data);
            throw new \RuntimeException("Can only wrap Content Elements, $type given.");
        }

        try
        {
            $property = array_key_exists('title', $mapping) ? $mapping['title'] : 'title';
            $title = $data->get($property);
        }
        catch (\Exception $e)
        {
            $title = array_key_exists('title', $params) ? $params['title'] : $data->getParameter('title');
        }

        if (empty($title))
        {
            throw new \RuntimeException("No 'title' property or parameter found.");
        }

        return new static($data, $title, $params);
    }
}
