<?php

namespace Joomla\Content\Element;

/**
 * Class Text
 *
 * Text (also body in journalism jargon) is a sequence of paragraphs and images.
 *
 * @package Joomla\Content\Element
 */
class Text extends AbstractElement
{
    /**
     * The text
     *
     * @var string
     */
    protected $text;

    /**
     * The level of the text
     *
     * @var integer
     */
    protected $level;

    /**
     * Text constructor.
     *
     * @param string $text The text
     * @param array $params The presentation parameters
     */
    public function __construct($text, $params = [])
    {
        $this->text = $text;

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
            $params
        );
    }
}
