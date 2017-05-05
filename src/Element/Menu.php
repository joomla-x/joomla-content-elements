<?php

namespace Joomla\Content\Element;

/**
 * Class Menu
 *
 * A menu is a list of options or commands presented to the user of a computer or communications system. A menu may
 * either be a system's entire user interface, or only part of a more complex one.
 *
 * A computer using a graphical user interface presents menus with a combination of text and symbols to represent
 * choices. By clicking on one of the symbols or text, the operator is selecting the instruction that the symbol
 * represents. A context menu is a menu in which the choices presented to the operator are automatically modified
 * according to the current context in which the operator is working.
 *
 * A common use of menus is to provide convenient access to various operations such as saving or opening a file,
 * quitting a program, or manipulating data. Most widget toolkits provide some form of pull-down or pop-up menu.
 * Pull-down menus are the type commonly used in menu bars (usually near the top of a window or screen), which are
 * most often used for performing actions, whereas pop-up (or "fly-out") menus are more likely to be used for setting
 * a value, and might appear anywhere in a window.
 *
 * _From [Wikipedia](https://en.wikipedia.org/wiki/Menu_(computing))_
 *
 * @package Joomla\Content\Element
 */
class Menu extends AbstractCompositeElement
{
    /**
     * The child elements
     *
     * @var Menu[]
     */
    protected $elements;

    /**
     * The expected class of child elements
     *
     * @var string
     */
    protected $elementType = Menu::class;

    /**
     * The label of the menu item
     *
     * @var string
     */
    protected $label;

    /**
     * The URL of the action
     *
     * @var string
     */
    protected $action;

    /**
     * The name of the icon
     *
     * @var string
     */
    protected $icon;

    /**
     * Menu constructor.
     *
     * @param string $label The label of the menu item
     * @param string $action The URL of the action
     * @param string $icon The name of the icon
     * @param Menu[] $elements The submenu items
     * @param array $params The presentation parameters
     */
    public function __construct($label, $action, $icon = null, $elements = [], $params = [])
    {
        $this->init($elements, $params);
        $this->label = $label;
        $this->action = $action;
        $this->icon = $icon;
    }

    /**
     * Create an element.
     *
     * @param array|object $data The menu data
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

        $children = [];
        $elements = array_key_exists('children', $map) ? $data[$map['children']] : [];
        foreach ($elements as $element)
        {
            $children[] = self::from($element, $mapping);
        }

        return new self(
            $data[$map['label']],
            $data[$map['action']],
            array_key_exists('icon', $map) ? $data[$map['icon']] : null,
            $children,
            $params
        );
    }
}
