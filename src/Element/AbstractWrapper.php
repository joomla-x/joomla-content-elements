<?php

namespace Joomla\Content\Element;

use Joomla\Content\ContentElementInterface;

abstract class AbstractWrapper extends AbstractElement
{
    /**
     * The wrapped element
     *
     * @var ContentElementInterface
     */
    protected $element;

    /**
     * AbstractWrapper constructor.
     *
     * @param ContentElementInterface $element The element to be wrapped
     * @param array $params The presentation parameters
     */
    public function __construct(ContentElementInterface $element, $params = [])
    {
        $this->element = $element;

        if (empty($params)) {
            $params = $element->getParameters();
        }
        $this->setParameters($params);
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
            return $this->element->get($property, $default);
        }

        return $this->{$property};
    }
}
