<?php

namespace Joomla\Content\Element;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\ContentVisitorInterface;

class Button extends AbstractElement
{
    protected $label;
    protected $url;
    protected $icon;

    public function __construct($label, $url, $icon = null, $params = [])
    {
        $this->label = $label;
        $this->url = $url;
        $this->icon = $icon;

        $this->setParameters($params);
    }

    /**
     * Create an element.
     *
     * @param array|object $data The data container
     * @param array $mapping The property mapping
     * @param array $params The presentation parameters
     *
     * @return ContentElementInterface
     */
    public static function from($data, $mapping = [], $params = [])
    {
        if (is_object($data))
        {
            $data = get_object_vars($data);
        }
        $keys = array_keys($data);
        $dataKeys = array_combine($keys, $keys);
        $map = array_merge($dataKeys, $mapping);

        return new self(
             $data[$map['label']],
             $data[$map['url']],
             $data[$map['icon']],
             $params
        );
    }

    /**
     * Visit the content element.
     *
     * @param ContentVisitorInterface $visitor The Visitor
     */
    public function accept(ContentVisitorInterface $visitor)
    {
        throw new \LogicException(__METHOD__ . ' is not implemented.');
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
        if (!property_exists(self::class, $property)) {
            throw new \RuntimeException("Property '$property' does not exist in '" . get_class($this));
        }

        return $this->{$property};
    }
}
