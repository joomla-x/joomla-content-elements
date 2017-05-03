<?php

namespace Joomla\Content\Element;

use Joomla\Content\CompositeElementInterface;
use Joomla\Content\ContentElementInterface;

abstract class AbstractCompositeElement extends AbstractElement implements CompositeElementInterface
{
    /**
     * The child elements
     *
     * @var ContentElementInterface[]
     */
    protected $elements;


    /**
     * @param ContentElementInterface[] $elements
     * @param array                     $params
     */
    protected function init($elements, $params)
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }

        $this->setParameters($params);
    }

    /**
     * Add a content element as a child.
     *
     * @param ContentElementInterface $element The content element
     */
    public function addElement(ContentElementInterface $element)
    {
        $this->elements[] = $element;
    }

    /**
     * Remove a content element.
     *
     * @param ContentElementInterface $element The content element
     */
    public function removeElement(ContentElementInterface $element)
    {
        foreach ($this->elements as $index => $contentElement) {
            if ($contentElement === $element) {
                unset($this->elements[$index]);

                return;
            }
        }

        throw new \RuntimeException('Unable to remove element');
    }

    /**
     * Get the child elements.
     *
     * @return ContentElementInterface[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Find the value for a property.
     *
     * @param string                  $key
     * @param ContentElementInterface $element
     * @param array                   $mapping
     * @param array                   $params
     *
     * @return mixed
     */
    protected static function findValueFor($key, $element, $mapping, $params)
    {
        try {
            $value = $element->get(array_key_exists($key, $mapping) ? $mapping[$key] : $key);
        } catch (\Exception $e) {
            $value = array_key_exists($key, $params) ? $params[$key] : $element->getParameter($key);
        }

        if (empty($value)) {
            throw new \RuntimeException("No '$key' property or parameter found.");
        }

        return $value;
    }

    /**
     * @param mixed $data
     */
    protected static function checkType($data)
    {
        if (!$data instanceof ContentElementInterface) {
            $type = is_object($data) ? get_class($data) : gettype($data);
            throw new \RuntimeException("Can only compose Content Elements, $type given.");
        }
    }
}
