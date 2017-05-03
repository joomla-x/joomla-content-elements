<?php

namespace Joomla\Tests\Content;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\Element\Headline;
use Joomla\Content\Element\Slider;
use Joomla\Content\Element\Panel;
use Joomla\Tests\Content\Mock\Visitor;

class SliderTest extends \PHPUnit\Framework\TestCase
{
    /** @var  ContentElementInterface[] */
    private $elements;

    /** @var  array */
    private $params;

    /** @var  Slider */
    private $slider;

    public function setUp()
    {
        $this->elements = [
            new Panel([], 'Pane 1'),
            new Panel([], 'Pane 2'),
        ];
        $this->params = [
            'class' => 'special',
        ];
        $this->slider = new Slider($this->elements, $this->params);
    }

    public function testSliderConstructor()
    {
        $this->assertEquals($this->elements, $this->slider->getElements(),
            'Property "elements" does not have the expected value');

        $this->assertEquals('special', $this->slider->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $this->slider->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testSliderThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $this->expectException(\Exception::class);

        $this->slider->get('nonexistent');
    }

    public function testSliderReturnsNullOnAccessOfNonexistentParameter()
    {
        $this->assertEquals(null, $this->slider->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testSliderReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $this->assertEquals('default', $this->slider->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testSliderCallsVisitorWithSlider()
    {
        $visitor = new Visitor();
        $this->slider->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Slider',
                $this->slider
            ],
            $call
        );
    }

    public function testSliderChildElementsCanBeRemoved()
    {
        $element = $this->elements[0];
        $count = count($this->slider->getElements());
        $this->slider->removeElement($element);

        $this->assertEquals($count - 1, count($this->slider->getElements()));
    }

    public function testSliderThrowsExceptionOnRemovalOfNonexistentChildElement()
    {
        $this->expectException(\Exception::class);

        $element = new Panel([], 'Title');
        $this->slider->removeElement($element);
    }

    public function testSliderThrowsExceptionOnWrongClass()
    {
        $this->expectException(\Exception::class);

        $element = new Headline('Foo');
        Slider::from($element);
    }
}
