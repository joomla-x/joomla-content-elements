<?php

namespace Joomla\Tests\Content;

use Joomla\Content\Element\Menu;
use Joomla\Tests\Content\Mock\Visitor;

class MenuTest extends \PHPUnit\Framework\TestCase
{
    private $label;
    private $action;
    private $icon;
    private $children;

    /** @var  array */
    private $params;

    /** @var  Menu */
    private $menu;

    public function setUp()
    {
        $menu3 = new Menu('Menu 3', 'action3.php');
        $menu2 = new Menu('Menu 2', 'action2.php');
        $menu12 = new Menu('Menu 1.2', 'action1b.php');
        $menu11 = new Menu('Menu 1.1', 'action1a.php');
        $menu1 = new Menu('Menu 1', 'action1.php', null, [$menu11, $menu12]);

        $this->params = [
            'class' => 'special',
        ];
        $this->label = 'Main Menu';
        $this->action = 'action0.php';
        $this->icon = 'menu';
        $this->children = [$menu1, $menu2, $menu3];

        $this->menu = new Menu($this->label, $this->action, $this->icon, $this->children, $this->params);
    }

    public function testMenuConstructor()
    {
        $this->assertEquals($this->label, $this->menu->get('label'),
            'Property "label" does not have the expected value');

        $this->assertEquals($this->action, $this->menu->get('action'),
            'Property "url" does not have the expected value');

        $this->assertEquals($this->icon, $this->menu->get('icon'),
            'Property "icon" does not have the expected value');

        $this->assertEquals($this->children, $this->menu->getElements(),
            'Property "elements" does not have the expected value');

        $this->assertEquals('special', $this->menu->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $this->menu->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testMenuFromArray()
    {
        $menuData = [
            'label' => 'Main Menu',
            'url' => '#',
            'children' => [
                [
                    'label' => 'Menu 1',
                    'url' => '#',
                    'children' => [],
                ],
                [
                    'label' => 'Menu 2',
                    'url' => '#',
                ],
            ]
        ];
        $map = [
            'action' => 'url',
        ];
        $params = [
            'class' => 'special',
        ];

        $menu = Menu::from($menuData, $map, $params);

        $this->assertEquals($menuData['label'], $menu->get('label'),
            'Property "label" does not have the expected value');

        $this->assertEquals($menuData['url'], $menu->get('action'),
            'Property "action" does not have the expected value');

        $submenu = $menu->getElements();

        for ($i = 0; $i < count($submenu); ++$i) {
            $this->assertEquals($menuData['children'][$i]['label'], $submenu[$i]->get('label'),
                "Property \"label\" of child $i does not have the expected value");

            $this->assertEquals($menuData['children'][$i]['url'], $submenu[$i]->get('action'),
                "Property \"action\" of child $i does not have the expected value");
        }

        $this->assertEquals('special', $menu->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $menu->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testMenuThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $this->expectException(\Exception::class);

        $this->menu->get('nonexistent');
    }

    public function testMenuReturnsNullOnAccessOfNonexistentParameter()
    {
        $this->assertEquals(null, $this->menu->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testMenuReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $this->assertEquals('default', $this->menu->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testMenuCallsVisitorWithMenu()
    {
        $visitor = new Visitor();
        $this->menu->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Menu',
                $this->menu
            ],
            $call
        );
    }

    public function testCanBeTraversedByVisitor()
    {
        $visitor = new Visitor();
        $this->menu->accept($visitor);

        $this->assertEquals(
            '<nav><h3>Main Menu</h3><ul><li>Menu 1<ul><li>Menu 1.1</li><li>Menu 1.2</li></ul></li><li>Menu 2</li><li>Menu 3</li></ul></nav>',
            $visitor->output
        );
    }

    public function testMenuChildElementsCanBeRemoved()
    {
        $element = $this->children[0];
        $count = count($this->menu->getElements());
        $this->menu->removeElement($element);

        $this->assertEquals($count - 1, count($this->menu->getElements()));
    }

    public function testMenuThrowsExceptionOnRemovalOfNonexistentChildElement()
    {
        $this->expectException(\Exception::class);

        $element = new Menu('Menu 4', 'action4.php');

        $this->menu->removeElement($element);
    }
}
