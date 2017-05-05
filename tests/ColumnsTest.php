<?php

namespace Joomla\Tests\Content;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\Element\Accordion;
use Joomla\Content\Element\Columns;
use Joomla\Content\Element\Panel;
use Joomla\Content\Element\Slider;
use Joomla\Tests\Content\Mock\Visitor;

class ColumnsTest extends \PHPUnit\Framework\TestCase
{
    /** @var  ContentElementInterface[] */
    private $elements;

    /** @var  array */
    private $params;

    /** @var  Columns */
    private $columns;

    public function setUp()
    {
        $this->elements = [
            new Accordion(),
            new Slider(),
        ];
        $this->params = [
            'class' => 'special',
        ];
        $this->columns = new Columns($this->elements, $this->params);
    }

    public function testColumnsConstructor()
    {
        $this->assertEquals($this->elements, $this->columns->getElements(),
            'Property "elements" does not have the expected value');

        $this->assertEquals('special', $this->columns->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $this->columns->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testColumnsThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $this->expectException(\Exception::class);

        $this->columns->get('nonexistent');
    }

    public function testColumnsReturnsNullOnAccessOfNonexistentParameter()
    {
        $this->assertEquals(null, $this->columns->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testColumnsReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $this->assertEquals('default', $this->columns->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testColumnsCallsVisitorWithColumns()
    {
        $visitor = new Visitor();
        $this->columns->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Columns',
                $this->columns
            ],
            $call
        );
    }

    public function testColumnsChildElementsCanBeRemoved()
    {
        $element = $this->elements[0];
        $count = count($this->columns->getElements());
        $this->columns->removeElement($element);

        $this->assertEquals($count - 1, count($this->columns->getElements()));
    }

    public function testColumnsThcolumnsExceptionOnRemovalOfNonexistentChildElement()
    {
        $this->expectException(\Exception::class);

        $element = new Panel([], 'Title');
        $this->columns->removeElement($element);
    }
}
