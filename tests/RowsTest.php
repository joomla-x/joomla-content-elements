<?php

namespace Joomla\Tests\Content;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\Element\Accordion;
use Joomla\Content\Element\Panel;
use Joomla\Content\Element\Rows;
use Joomla\Content\Element\Slider;
use Joomla\Tests\Content\Mock\Visitor;

class RowsTest extends \PHPUnit\Framework\TestCase
{
    /** @var  ContentElementInterface[] */
    private $elements;

    /** @var  array */
    private $params;

    /** @var  Rows */
    private $rows;

    public function setUp()
    {
        $this->elements = [
            new Accordion(),
            new Slider(),
        ];
        $this->params = [
            'class' => 'special',
        ];
        $this->rows = new Rows($this->elements, $this->params);
    }

    public function testRowsConstructor()
    {
        $this->assertEquals($this->elements, $this->rows->getElements(),
            'Property "elements" does not have the expected value');

        $this->assertEquals('special', $this->rows->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $this->rows->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testRowsThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $this->expectException(\Exception::class);

        $this->rows->get('nonexistent');
    }

    public function testRowsReturnsNullOnAccessOfNonexistentParameter()
    {
        $this->assertEquals(null, $this->rows->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testRowsReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $this->assertEquals('default', $this->rows->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testRowsCallsVisitorWithRows()
    {
        $visitor = new Visitor();
        $this->rows->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Rows',
                $this->rows
            ],
            $call
        );
    }

    public function testRowsChildElementsCanBeRemoved()
    {
        $element = $this->elements[0];
        $count = count($this->rows->getElements());
        $this->rows->removeElement($element);

        $this->assertEquals($count - 1, count($this->rows->getElements()));
    }

    public function testRowsThrowsExceptionOnRemovalOfNonexistentChildElement()
    {
        $this->expectException(\Exception::class);

        $element = new Panel([], 'Title');
        $this->rows->removeElement($element);
    }
}
