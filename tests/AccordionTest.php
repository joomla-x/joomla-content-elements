<?php

namespace Joomla\Tests\Content;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\Element\Accordion;
use Joomla\Content\Element\Headline;
use Joomla\Content\Element\Panel;
use Joomla\Tests\Content\Mock\Visitor;

class AccordionTest extends \PHPUnit\Framework\TestCase
{
    /** @var  ContentElementInterface[] */
    private $elements;

    /** @var  array */
    private $params;

    /** @var  Accordion */
    private $accordion;

    public function setUp()
    {
        $this->elements = [
            new Panel([], 'Pane 1'),
            new Panel([], 'Pane 2'),
        ];
        $this->params = [
            'class' => 'special',
        ];
        $this->accordion = new Accordion($this->elements, $this->params);
    }

    public function testAccordionConstructor()
    {
        $this->assertEquals($this->elements, $this->accordion->getElements(),
            'Property "elements" does not have the expected value');

        $this->assertEquals('special', $this->accordion->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $this->accordion->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testAccordionThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $this->expectException(\Exception::class);

        $this->accordion->get('nonexistent');
    }

    public function testAccordionReturnsNullOnAccessOfNonexistentParameter()
    {
        $this->assertEquals(null, $this->accordion->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testAccordionReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $this->assertEquals('default', $this->accordion->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testAccordionCallsVisitorWithAccordion()
    {
        $visitor = new Visitor();
        $this->accordion->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Accordion',
                $this->accordion
            ],
            $call
        );
    }

    public function testAccordionChildElementsCanBeRemoved()
    {
        $element = $this->elements[0];
        $count = count($this->accordion->getElements());
        $this->accordion->removeElement($element);

        $this->assertEquals($count - 1, count($this->accordion->getElements()));
    }

    public function testAccordionThrowsExceptionOnRemovalOfNonexistentChildElement()
    {
        $this->expectException(\Exception::class);

        $element = new Panel([], 'Title');
        $this->accordion->removeElement($element);
    }

    public function testAccordionThrowsExceptionOnWrongClass()
    {
        $this->expectException(\Exception::class);

        $element = new Headline('Foo');
        Accordion::from($element);
    }
}
