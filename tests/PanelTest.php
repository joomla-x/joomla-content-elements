<?php

namespace Joomla\Tests\Content;

use Joomla\Content\Element\Button;
use Joomla\Content\Element\Headline;
use Joomla\Content\Element\Panel;
use Joomla\Tests\Content\Mock\Visitor;

class PanelTest extends \PHPUnit\Framework\TestCase
{
    public function testPanelConstructor()
    {
        $elements = [
            new Headline('Foo'),
            new Button('Ok', '#'),
        ];
        $title = 'Composed Element';
        $params = [
            'class' => 'special',
        ];
        $panel = new Panel($elements, $title, $params);

        $this->assertEquals($elements, $panel->getElements(),
            'Property "elements" does not have the expected value');
        $this->assertEquals($title, $panel->get('title'), 'Property "title" does not have the expected value');
        $this->assertEquals('special', $panel->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $panel->getParameters(),
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
        $elements = [
            new Headline('Foo'),
            new Button('Ok', '#'),
        ];
        $title = 'Composed Element';
        $params = [
            'class' => 'special',
        ];
        $panel = new Panel($elements, $title, $params);

        $this->expectException(\Exception::class);
        $panel->get('nonexistent');
    }

    public function testPanelReturnsNullOnAccessOfNonexistentParameter()
    {
        $elements = [
            new Headline('Foo'),
            new Button('Ok', '#'),
        ];
        $title = 'Composed Element';
        $params = [
            'class' => 'special',
        ];
        $panel = new Panel($elements, $title, $params);

        $this->assertEquals(null, $panel->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testPanelReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $elements = [
            new Headline('Foo'),
            new Button('Ok', '#'),
        ];
        $title = 'Composed Element';
        $params = [
            'class' => 'special',
        ];
        $panel = new Panel($elements, $title, $params);

        $this->assertEquals('default', $panel->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testPanelCallsVisitorWithPanel()
    {
        $elements = [
            new Headline('Foo'),
            new Button('Ok', '#'),
        ];
        $title = 'Composed Element';
        $params = [
            'class' => 'special',
        ];
        $panel = new Panel($elements, $title, $params);
        $visitor = new Visitor();
        $panel->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Panel',
                $panel
            ],
            $call
        );
    }
}
