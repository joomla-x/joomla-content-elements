<?php

namespace Joomla\Content\Element;

/**
 * Class Button
 *
 * A typical button is a rectangle or rounded rectangle, wider than it is tall, with a descriptive caption in its center.
 * The most common method of pressing a button is clicking it with a pointer controlled by a mouse, but other input such
 * as keystrokes can be used to execute the command of a button. A button is not however always restricted to a
 * rectangular shape. The sole requirement of button interaction is that the user can execute a command by a click
 * action. Thus pictures and background areas can be programmed as buttons. When pressed, in addition to performing a
 * predetermined task, buttons often undergo a graphical change to mimic a mechanical button being depressed.
 *
 * A button often displays a tooltip when a user moves the pointer over it. The tooltip serves as built-in documentation
 * that briefly explains the purpose of the button.
 *
 * Some very common incarnations of the button widget are:
 *
 * - An OK button for confirming actions and closing the windows
 * - A Cancel button for canceling actions and closing the window
 * - An Apply button for confirming actions without closing the window
 * - A Close button for closing windows after changes have already been applied
 *
 * _From [Wikipedia](https://en.wikipedia.org/wiki/Button_(computing))_
 *
 * @package Joomla\Content\Element
 */
class Button extends AbstractElement
{
    /**
     * The text on the button
     *
     * @var string
     */
    protected $label;

    /**
     * The link to the action
     *
     * @var string
     */
    protected $url;

    /**
     * A hint about the action
     *
     * @var string
     */
    protected $hint;

    /**
     * An optional icon name to represent the action
     *
     * @var string
     */
    protected $icon = null;

    /**
     * Button constructor.
     *
     * @param string $label The text on the button
     * @param string $url The link to the action
     * @param string $hint A hint about the action
     * @param string $icon An optional icon name to represent the action
     * @param array $params The presentation parameters
     */
    public function __construct($label, $url, $hint = null, $icon = null, $params = [])
    {
        $this->label = $label;
        $this->url = $url;
        $this->hint = $hint;
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
            $data[$map['label']],
            $data[$map['url']],
            array_key_exists('hint', $data) ? $data[$map['hint']] : null,
            array_key_exists('icon', $data) ? $data[$map['icon']] : null,
            $params
        );
    }
}
