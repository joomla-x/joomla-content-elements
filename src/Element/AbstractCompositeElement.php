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
     * The expected class of child elements
     *
     * @var string
     */
    protected $elementType = ContentElementInterface::class;

    /**
     * Find the value for a property.
     *
     * @param string $key
     * @param ContentElementInterface $element
     * @param array $mapping
     * @param array $params
     *
     * @return mixed
     */
    protected static function findValueFor($key, $element, $mapping, $params)
    {
        $key = array_key_exists($key, $mapping) ? $mapping[$key] : $key;

        if (array_key_exists($key, $params)) {
            return $params[$key];
        }

        if ($element instanceof ContentElementInterface) {
            try {
                return $element->getParameter($key, $element->get($key));
            } catch (\Throwable $e) {
                // Do nothing
            }
        }

        throw new \RuntimeException("No '$key' property or parameter found.");
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
     * @param ContentElementInterface[] $elements
     * @param array $params
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
        $this->checkType($element);

        $this->elements[] = $element;
    }

    /**
     * @param mixed $data
     */
    protected function checkType($data)
    {
        if (!$data instanceof $this->elementType) {
            $actual = is_object($data) ? get_class($data) : gettype($data);
            throw new \RuntimeException("Can only use child elements of type {$this->elementType}, $actual given.");
        }
    }
}
