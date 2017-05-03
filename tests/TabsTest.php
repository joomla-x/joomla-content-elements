<?php

namespace Joomla\Tests\Content;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\Element\Headline;
use Joomla\Content\Element\Tabs;
use Joomla\Content\Element\Panel;
use Joomla\Tests\Content\Mock\Visitor;

class TabsTest extends \PHPUnit\Framework\TestCase
{
    /** @var  ContentElementInterface[] */
    private $elements;

    /** @var  array */
    private $params;

    /** @var  Tabs */
    private $tabs;

    public function setUp()
    {
        $this->elements = [
            new Panel([], 'Pane 1'),
            new Panel([], 'Pane 2'),
        ];
        $this->params = [
            'class' => 'special',
        ];
        $this->tabs = new Tabs($this->elements, $this->params);
    }

    public function testTabsConstructor()
    {
        $this->assertEquals($this->elements, $this->tabs->getElements(),
            'Property "elements" does not have the expected value');

        $this->assertEquals('special', $this->tabs->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $this->tabs->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testTabsThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $this->expectException(\Exception::class);

        $this->tabs->get('nonexistent');
    }

    public function testTabsReturnsNullOnAccessOfNonexistentParameter()
    {
        $this->assertEquals(null, $this->tabs->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testTabsReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $this->assertEquals('default', $this->tabs->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testTabsCallsVisitorWithTabs()
    {
        $visitor = new Visitor();
        $this->tabs->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Tabs',
                $this->tabs
            ],
            $call
        );
    }

    public function testTabsChildElementsCanBeRemoved()
    {
        $element = $this->elements[0];
        $count = count($this->tabs->getElements());
        $this->tabs->removeElement($element);

        $this->assertEquals($count - 1, count($this->tabs->getElements()));
    }

    public function testTabsThrowsExceptionOnRemovalOfNonexistentChildElement()
    {
        $this->expectException(\Exception::class);

        $element = new Panel([], 'Title');
        $this->tabs->removeElement($element);
    }

    public function testTabsThrowsExceptionOnWrongClass()
    {
        $this->expectException(\Exception::class);

        $element = new Headline('Foo');
        Tabs::from($element);
    }
}
