<?php

namespace Joomla\Tests\Content;

use Joomla\Content\Element\Text;
use Joomla\Tests\Content\Mock\Visitor;

class TextTest extends \PHPUnit\Framework\TestCase
{
    /** @var  string */
    private $text;

    /** @var  array */
    private $params;

    /** @var  Text */
    private $textElement;

    public function setUp()
    {
        $this->text = '<p>Foo</p><p>Bar</p>';
        $this->params = [
            'class' => 'special',
        ];
        $this->textElement = new Text($this->text, $this->params);
    }

    public function testTextConstructor()
    {
        $this->assertEquals($this->text, $this->textElement->get('text'),
            'Property "text" does not have the expected value');
        $this->assertEquals('special', $this->textElement->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $this->textElement->getParameters(),
            'Parameter array does not have the expected values');
    }

    public function testTextFromArray()
    {
        $properties = [
            'text' => $this->text,
        ];
        $text = Text::from($properties, [], $this->params);

        $this->assertEquals($properties['text'], $text->get('text'),
            'Property "text" does not have the expected value');
        $this->assertEquals('special', $text->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $text->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testTextFromArrayWithMapping()
    {
        $properties = [
            'orig_text' => $this->text,
        ];
        $map = [
            'text' => 'orig_text',
        ];
        $text = Text::from($properties, $map, $this->params);

        $this->assertEquals($properties['orig_text'], $text->get('text'),
            'Property "text" does not have the expected value');
        $this->assertEquals('special', $text->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $text->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testTextFromObject()
    {
        $properties = (object)[
            'text' => $this->text,
        ];
        $text = Text::from($properties, [], $this->params);

        $this->assertEquals($properties->text, $text->get('text'),
            'Property "text" does not have the expected value');
        $this->assertEquals('special', $text->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $text->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testTextFromObjectWithMapping()
    {
        $properties = (object)[
            'orig_text' => $this->text,
        ];
        $map = [
            'text' => 'orig_text',
        ];
        $text = Text::from($properties, $map, $this->params);

        $this->assertEquals($properties->orig_text, $text->get('text'),
            'Property "text" does not have the expected value');
        $this->assertEquals('special', $text->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($this->params, $text->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testTextThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $this->expectException(\Exception::class);
        $this->textElement->get('nonexistent');
    }

    public function testTextReturnsNullOnAccessOfNonexistentParameter()
    {
        $this->assertEquals(null, $this->textElement->getParameter('unknown'),
            'Unknown parameter does not return null');
    }

    public function testTextReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $this->assertEquals('default', $this->textElement->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testTextCallsVisitorWithText()
    {
        $visitor = new Visitor();
        $this->textElement->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Text',
                $this->textElement
            ],
            $call
        );
    }
}
