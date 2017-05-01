<?php

namespace Joomla\Content\Element;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\ContentVisitorInterface;

abstract class AbstractElement implements ContentElementInterface
{
    /**
     * The presentation parameters
     *
     * @var array
     */
    protected $params = [];

    /**
     * Visit the content element.
     *
     * @param ContentVisitorInterface $visitor The Visitor
     */
    public function accept(ContentVisitorInterface $visitor)
    {
        $elementType = preg_replace('~^.*\\\~', '', static::class);
        $visitor->visit($elementType, $this);
    }

    /**
     * Get the value of a property.
     *
     * @param string $property The property
     * @param mixed $default The default value
     *
     * @return mixed
     */
    public function get($property, $default = null)
    {
        if (!property_exists(static::class, $property)) {
            throw new \RuntimeException("Property '$property' does not exist in '" . get_class($this));
        }

        return $this->{$property};
    }

    /**
     * Get the parameters for the element.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->params;
    }

    /**
     * Get a parameter for the content.
     *
     * @param string $key The key
     * @param mixed $default The default value
     *
     * @return mixed
     */
    public function getParameter($key, $default = null)
    {
        return array_key_exists($key, $this->params) ? $this->params[$key] : $default;
    }

    /**
     * Set the parameters.
     *
     * @param $parameters
     */
    protected function setParameters($parameters)
    {
        $this->params = $parameters;
    }
}
