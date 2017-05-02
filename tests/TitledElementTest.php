<?php

namespace Joomla\Tests\Content;

use Joomla\Content\Element\Headline;
use Joomla\Content\Element\TitledElement;
use Joomla\Tests\Content\Mock\Visitor;

class TitledElementTest extends \PHPUnit\Framework\TestCase
{
    public function testTitledElementConstructor()
    {
        $element = new Headline('Foo');
        $title = 'Wrapped Element';
        $params = [
            'class' => 'special',
        ];
        $titledElement = new TitledElement($element, $title, $params);

        $this->assertEquals($element, $titledElement->get('element'),
            'Property "element" does not have the expected value');
        $this->assertEquals($title, $titledElement->get('title'), 'Property "title" does not have the expected value');
        $this->assertEquals('special', $titledElement->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $titledElement->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testTitledElementFromArrayWithTitleFromProperties()
    {
        $element = new Headline('Foo');
        $map = [
            'title' => 'text',
        ];
        $params = [
            'class' => 'special',
        ];
        $titledElement = TitledElement::from($element, $map, $params);

        $this->assertEquals($element, $titledElement->get('element'),
            'Property "element" does not have the expected value');
        $this->assertEquals('Foo', $titledElement->get('title'), 'Property "title" does not have the expected value');
        $this->assertEquals('special', $titledElement->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $titledElement->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testTitledElementFromArrayWithTitleFromParameters()
    {
        $element = new Headline('Foo');
        $title = 'Wrapped Element';
        $map = [
            'element' => 'orig_text',
        ];
        $params = [
            'class' => 'special',
            'title' => $title,
        ];
        $titledElement = TitledElement::from($element, $map, $params);

        $this->assertEquals($element, $titledElement->get('element'),
            'Property "element" does not have the expected value');
        $this->assertEquals($title, $titledElement->get('title'),
            'Property "title" does not have the expected value');
        $this->assertEquals('special', $titledElement->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $titledElement->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testTitledElementThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $element = new Headline('Foo');
        $title = 'Wrapped Element';
        $params = [
            'class' => 'special',
        ];
        $titledElement = new TitledElement($element, $title, $params);

        $this->expectException(\Exception::class);
        $titledElement->get('nonexistent');
    }

    public function testTitledElementReturnsNullOnAccessOfNonexistentParameter()
    {
        $element = new Headline('Foo');
        $title = 'Wrapped Element';
        $params = [
            'class' => 'special',
        ];
        $titledElement = new TitledElement($element, $title, $params);

        $this->assertEquals(null, $titledElement->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testTitledElementReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $element = new Headline('Foo');
        $title = 'Wrapped Element';
        $params = [
            'class' => 'special',
        ];
        $titledElement = new TitledElement($element, $title, $params);

        $this->assertEquals('default', $titledElement->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testTitledElementCallsVisitorWithTitledElement()
    {
        $element = new Headline('Foo');
        $title = 'Wrapped Element';
        $params = [
            'class' => 'special',
        ];
        $titledElement = new TitledElement($element, $title, $params);
        $visitor = new Visitor();
        $titledElement->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'TitledElement',
                $titledElement
            ],
            $call
        );
    }
}
