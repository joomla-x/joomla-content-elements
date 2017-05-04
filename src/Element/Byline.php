<?php

namespace Joomla\Content\Element;

/**
 * Class Byline
 *
 * The byline on a newspaper or magazine article gives the date, as well as the name of the writer of the article.
 * Bylines are commonly placed between the headline and the text of the article, although some magazines (notably
 * Reader's Digest) place bylines at the bottom of the page to leave more room for graphical elements around the
 * headline.
 *
 * The dictionary defines a byline as "a printed line of text accompanying a news story, article, or the like, giving
 * the author's name."
 *
 * _From [Wikipedia](https://en.wikipedia.org/wiki/Byline)_
 *
 * @package Joomla\Content\Element
 */
class Byline extends AbstractElement
{
    /**
     * The date of writing
     *
     * @var \DateTime
     */
    protected $date;

    /**
     * The name of the author
     *
     * @var string
     */
    protected $author;

    /**
     * The position of the author
     *
     * @var string
     */
    protected $position;

    /**
     * Byline constructor.
     *
     * @param \DateTime $date The date of writing
     * @param string $author The name of the author
     * @param string $position The position of the author
     * @param array $params The presentation parameters
     */
    public function __construct($date = null, $author = null, $position = null, $params = [])
    {
        $this->date = $date;
        $this->author = $author;
        $this->position = $position;
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
            array_key_exists('date', $map) ? $data[$map['date']] : null,
            array_key_exists('author', $map) ? $data[$map['author']] : null,
            array_key_exists('position', $map) ? $data[$map['position']] : null,
            $params
        );
    }
}
