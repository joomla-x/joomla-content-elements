<?php

namespace Joomla\Tests\Content;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\Element\Button;
use Joomla\Content\Element\Headline;
use Joomla\Content\Element\Panel;
use Joomla\Tests\Content\Mock\Visitor;

class PanelTest extends \PHPUnit\Framework\TestCase
{
    /** @var  ContentElementInterface[] */
    private $elements;

    /** @var  string */
    private $title;

    /** @var  array */
    private $params;

    /** @var  Panel */
    private $panel;

    public function setUp()
    {
        $this->elements = [
            new Headline('Foo'),
            new Button('Ok', '#'),
        ];
        $this->title = 'Composed Element';
        $this->params = [
            'class' => 'special',
        ];
        $this->panel = new Panel($this->elements, $this->title, $this->params);
    }

    public function testPanelConstructor()
    {
        $this->assertEquals($this->elements, $this->panel->getElements(),
            'Property "elements" does not have the expected value');

        $this->assertEquals($this->title, $this->panel->get('title'),
            'Property "title" does not have the expected value');

        $this->assertEquals('special', $this->panel->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $this->panel->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testPanelFromArrayWithTitleFromProperties()
    {
        $element = new Headline('Foo');
        $map = [
            'title' => 'text',
        ];
        $params = [
            'class' => 'special',
        ];
        $panel = Panel::from($element, $map, $params);

        $this->assertEquals([$element], $panel->getElements(),
            'Property "elements" does not have the expected value');

        $this->assertEquals('Foo', $panel->get('title'), 'Property "title" does not have the expected value');

        $this->assertEquals('special', $panel->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $panel->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testPanelFromArrayWithTitleFromParameters()
    {
        $element = new Headline('Foo');
        $title = 'Composed Element';
        $map = [
            'element' => 'orig_text',
        ];
        $params = [
            'class' => 'special',
            'title' => $title,
        ];
        $panel = Panel::from($element, $map, $params);

        $this->assertEquals([$element], $panel->getElements(),
            'Property "element" does not have the expected value');
        $this->assertEquals($title, $panel->get('title'),
            'Property "title" does not have the expected value');
        $this->assertEquals('special', $panel->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $panel->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testPanelThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $this->expectException(\Exception::class);

        $this->panel->get('nonexistent');
    }

    public function testPanelReturnsNullOnAccessOfNonexistentParameter()
    {
        $this->assertEquals(null, $this->panel->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testPanelReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $this->assertEquals('default', $this->panel->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testPanelCallsVisitorWithPanel()
    {
        $visitor = new Visitor();
        $this->panel->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Panel',
                $this->panel
            ],
            $call
        );
    }

    public function testPanelChildElementsCanBeRemoved()
    {
        $element = $this->elements[0];
        $count = count($this->panel->getElements());
        $this->panel->removeElement($element);

        $this->assertEquals($count - 1, count($this->panel->getElements()));
    }

    public function testPanelThrowsExceptionOnRemovalOfNonexistentChildElement()
    {
        $this->expectException(\Exception::class);

        $element = new Headline('Bar');
        $this->panel->removeElement($element);
    }

    public function testPanelThrowsExceptionOnWrongClass()
    {
        $this->expectException(\Exception::class);

        /** @var ContentElementInterface $element */
        $element = new \stdClass();
        Panel::from($element);
    }

    public function testPanelThrowsExceptionOnMissingProperty()
    {
        $this->expectException(\Exception::class);

        $element = new Headline('Bar');
        Panel::from($element);
    }
}
