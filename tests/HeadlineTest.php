<?php

namespace Joomla\Tests\Content;

use Joomla\Content\Element\Headline;
use Joomla\Tests\Content\Mock\Visitor;

class HeadlineTest extends \PHPUnit\Framework\TestCase
{
    public function testHeadlineConstructor()
    {
        $text = 'Foo';
        $level = 2;
        $params = [
            'class' => 'special',
        ];
        $headline = new Headline($text, $level, $params);

        $this->assertEquals($text, $headline->get('text'), 'Property "text" does not have the expected value');
        $this->assertEquals($level, $headline->get('level'), 'Property "level" does not have the expected value');
        $this->assertEquals('special', $headline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $headline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testHeadlineFromArray()
    {
        $properties = [
            'text' => 'Foo',
            'level' => 2,
        ];
        $params = [
            'class' => 'special',
        ];
        $headline = Headline::from($properties, [], $params);

        $this->assertEquals($properties['text'], $headline->get('text'),
            'Property "text" does not have the expected value');
        $this->assertEquals($properties['level'], $headline->get('level'), 'Property "level" does not have the expected value');
        $this->assertEquals('special', $headline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $headline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testHeadlineFromArrayWithMapping()
    {
        $properties = [
            'orig_text' => 'Foo',
            'orig_level' => 2,
        ];
        $map = [
            'text' => 'orig_text',
            'level' => 'orig_level',
        ];
        $params = [
            'class' => 'special',
        ];
        $headline = Headline::from($properties, $map, $params);

        $this->assertEquals($properties['orig_text'], $headline->get('text'),
            'Property "text" does not have the expected value');
        $this->assertEquals($properties['orig_level'], $headline->get('level'),
            'Property "level" does not have the expected value');
        $this->assertEquals('special', $headline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $headline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testHeadlineFromObject()
    {
        $properties = (object)[
            'text' => 'Foo',
            'level' => 2,
        ];
        $params = [
            'class' => 'special',
        ];
        $headline = Headline::from($properties, [], $params);

        $this->assertEquals($properties->text, $headline->get('text'),
            'Property "text" does not have the expected value');
        $this->assertEquals($properties->level, $headline->get('level'), 'Property "level" does not have the expected value');
        $this->assertEquals('special', $headline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $headline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testHeadlineFromObjectWithMapping()
    {
        $properties = (object)[
            'orig_text' => 'Foo',
            'orig_level' => 2,
        ];
        $map = [
            'text' => 'orig_text',
            'level' => 'orig_level',
        ];
        $params = [
            'class' => 'special',
        ];
        $headline = Headline::from($properties, $map, $params);

        $this->assertEquals($properties->orig_text, $headline->get('text'),
            'Property "text" does not have the expected value');
        $this->assertEquals($properties->orig_level, $headline->get('level'),
            'Property "level" does not have the expected value');
        $this->assertEquals('special', $headline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $headline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testHeadlineThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $text = 'Foo';
        $level = 2;
        $params = [
            'class' => 'special',
        ];
        $headline = new Headline($text, $level, $params);

        $this->expectException(\Exception::class);
        $headline->get('nonexistent');
    }

    public function testHeadlineReturnsNullOnAccessOfNonexistentParameter()
    {
        $text = 'Foo';
        $level = 2;
        $params = [
            'class' => 'special',
        ];
        $headline = new Headline($text, $level, $params);

        $this->assertEquals(null, $headline->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testHeadlineReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $text = 'Foo';
        $level = 2;
        $params = [
            'class' => 'special',
        ];
        $headline = new Headline($text, $level, $params);

        $this->assertEquals('default', $headline->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testHeadlineCallsVisitorWithHeadline()
    {
        $text = 'Foo';
        $level = 2;
        $params = [
            'class' => 'special',
        ];
        $headline = new Headline($text, $level, $params);
        $visitor = new Visitor();
        $headline->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Headline',
                $headline
            ],
            $call
        );
    }
}
