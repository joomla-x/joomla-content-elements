<?php

namespace Joomla\Tests\Content\Mock;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\ContentVisitorInterface;
use Joomla\Content\Element\Menu;

class Visitor implements ContentVisitorInterface
{
    public $output = '';
    public $calls = [];

    /**
     * Process the content.
     *
     * @param string $elementName The name of the content element
     * @param ContentElementInterface $content The content
     */
    public function visit($elementName, ContentElementInterface $content)
    {
        $this->calls[__FUNCTION__][] = [
            'elementName' => $elementName,
            'content' => $content,
        ];

        if ($elementName == 'Menu') {
            /** @var Menu $content */
            $this->visitMenu($content);
        }
    }

    /**
     * @param Menu $content
     */
    private function visitMenu(Menu $content)
    {
        /** @var Menu[] $menuItems */
        $menuItems = $content->getElements();
        $this->output .= sprintf(
            '<nav><h3>%s</h3>%s</nav>',
            $content->get('label'),
            $this->renderSubMenu($menuItems)
        );
    }

    /**
     * @param Menu[] $menuItems
     * @return string
     */
    private function renderSubMenu($menuItems)
    {
        if (empty($menuItems)) {
            return '';
        }

        $menu = '<ul>';
        foreach ($menuItems as $item) {
            /** @var Menu[] $subItems */
            $subItems = $item->getElements();
            $menu .= sprintf(
                '<li>%s%s</li>',
                $item->get('label'),
                $this->renderSubMenu($subItems)
            );
        }
        $menu .= '</ul>';

        return $menu;
    }

    /**
     * Register a content element.
     *
     * @param string $elementName The name of the content element
     * @param callable|array|string $handler The handler for that element
     */
    public function registerContentType($elementName, $handler)
    {
        $this->calls[__FUNCTION__][] = [
            'elementName' => $elementName,
            'handler' => $handler,
        ];
    }
}
