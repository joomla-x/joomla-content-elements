<?php

namespace Joomla\Content\Element;

/**
 * Class Headline
 *
 * @package Joomla\Content\Element
 */
class Headline extends AbstractElement
{
    /**
     * The text for the headline
     *
     * @var string
     */
    protected $text;

    /**
     * The level of the headline
     *
     * @var integer
     */
    protected $level;

    /**
     * Headline constructor.
     *
     * @param string $text The text for the headline
     * @param integer $level The level of the headline, defaults to 1
     * @param array $params The presentation parameters
     */
    public function __construct($text, $level = 1, $params = [])
    {
        $this->text = $text;
        $this->level = (int) $level;

        $this->setParameters($params);
    }

    /**
     * Create an element.
     *
     * @param array|object $data The data container
     * @param array $mapping The property mapping
     * @param array $params The presentation parameters
     *
     * @return self
     */
    public static function from($data, $mapping = [], $params = [])
    {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        $keys = array_keys($data);
        $dataKeys = array_combine($keys, $keys);
        $map = array_merge($dataKeys, $mapping);

        return new self(
            $data[$map['text']],
            array_key_exists('level', $map) ? $data[$map['level']] : 1,
            $params
        );
    }
}
