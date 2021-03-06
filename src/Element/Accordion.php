<?php

namespace Joomla\Content\Element;

/**
 * Class Accordion
 *
 * An accordion is a graphical control element comprising a vertically stacked list of items, such as labels or
 * thumbnails. Each item can be "expanded" or "stretched" to reveal the content associated with that item. There can
 * be zero expanded items, exactly one, or more than one item expanded at a time, depending on the configuration.
 *
 * The term stems from the musical accordion in which sections of the bellows can be expanded by pulling outward.
 *
 * A common example of an accordion is the Show/Hide operation of a box region, but extended to have multiple sections
 * in a list.
 *
 * An accordion is similar in purpose to a tabbed interface, a list of items where exactly one item is expanded into a
 * panel (i.e. list items are shortcuts to access separate panels).
 *
 * Several buttons or labels are stacked upon one another. At most one of them can be "active". When a button is active
 * the space below the button is used to display a paned window. The pane is usually constrained by the width of labels.
 * When opened it shifts labels under the clicked label down according to the height of that window. Only one button or
 * pane combination can be active at any one time; when a button is selected any other active panes cease to be active
 * and are hidden. The active pane may have scrollbars.
 *
 * - Brings windows together which ought to have some relation to each other.
 * - One window available at a time: to reduce information "overload" only one window is "opened".
 * - Unavailable windows are "shortcutted" / shaded to make choice faster. Chat program Google Talk rewrites window
 *   labels to indicate important states like "someone is writing" ...
 * - All windows stacked on each other together - see Fitts's law for further information about it.
 *
 * _From [Wikipedia](https://en.wikipedia.org/wiki/Accordion_(GUI))_
 *
 * @package Joomla\Content\Element
 */
class Accordion extends AbstractCompositeElement
{
    /**
     * The child elements
     *
     * @var Panel[]
     */
    protected $elements;

    /**
     * The expected class of child elements
     *
     * @var string
     */
    protected $elementType = Panel::class;

    /**
     * Accordion constructor.
     *
     * @param Panel[] $elements The panels of the accordion
     * @param array $params The presentation parameters
     */
    public function __construct($elements = [], $params = [])
    {
        $this->init($elements, $params);
    }

    /**
     * Create an element.
     *
     * @param Panel $data The element to be wrapped
     * @param array $mapping The property mapping
     * @param array $params The presentation parameters
     *
     * @return self
     */
    public static function from($data, $mapping = [], $params = [])
    {
        return new static([$data], $params);
    }
}
