<?php

namespace Joomla\Content\Element;

/**
 * Class Headline
 *
 * The headline (also heading, head or title, or hed in journalism jargon) of a story is typically a complete sentence
 * (e.g., "Pilot Flies Below Bridges to Save Divers"), often with auxiliary verbs and articles removed (e.g., "Remains
 * at Colorado camp linked to missing Chicago man"). However, headlines sometimes omit the subject (e.g., "Jumps From
 * Boat, Catches in Wheel") or verb (e.g., "Cat woman lucky").
 *
 * _From [Wikipedia](https://en.wikipedia.org/wiki/News_style#Headline)_
 *
 * _See also:_
 *
 * [Glossary of Journalism](https://en.wiktionary.org/wiki/Appendix:Glossary_of_journalism#Article_components) on Wiktionary
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
     * @param integer $level The level of the headline. By default, the level is auto-detected depending on nesting. starting with 1
     * @param array $params The presentation parameters
     */
    public function __construct($text, $level = 1, $params = [])
    {
        $this->text = $text;
        $this->level = (int)$level;

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
