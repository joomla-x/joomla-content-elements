<?php

namespace Joomla\Tests\Content;

use Joomla\Content\Element\Byline;
use Joomla\Tests\Content\Mock\Visitor;

class BylineTest extends \PHPUnit\Framework\TestCase
{
    public function testBylineConstructor()
    {
        $date = new \DateTime();
        $author = 'John Doe';
        $position = 'Editorial Chief in Charge';
        $params = [
            'class' => 'special',
        ];
        $byline = new Byline($date, $author, $position, $params);

        $this->assertEquals($date, $byline->get('date'), 'Property "date" does not have the expected value');
        $this->assertEquals($author, $byline->get('author'), 'Property "author" does not have the expected value');
        $this->assertEquals($position, $byline->get('position'), 'Property "position" does not have the expected value');
        $this->assertEquals('special', $byline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $byline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testBylineFromArray()
    {
        $properties = [
            'date' => new \DateTime(),
            'author' => 'John Doe',
            'position' => 'Editorial Chief in Charge',
        ];
        $params = [
            'class' => 'special',
        ];
        $byline = Byline::from($properties, [], $params);

        $this->assertEquals($properties['date'], $byline->get('date'),
            'Property "date" does not have the expected value');
        $this->assertEquals($properties['author'], $byline->get('author'), 'Property "author" does not have the expected value');
        $this->assertEquals($properties['position'], $byline->get('position'), 'Property "position" does not have the expected value');
        $this->assertEquals('special', $byline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $byline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testBylineFromArrayWithMapping()
    {
        $properties = [
            'orig_date' => new \DateTime(),
            'orig_author' => 'John Doe',
            'position' => 'Editorial Chief in Charge',
        ];
        $map = [
            'date' => 'orig_date',
            'author' => 'orig_author',
        ];
        $params = [
            'class' => 'special',
        ];
        $byline = Byline::from($properties, $map, $params);

        $this->assertEquals($properties['orig_date'], $byline->get('date'),
            'Property "date" does not have the expected value');
        $this->assertEquals($properties['orig_author'], $byline->get('author'),
            'Property "author" does not have the expected value');
        $this->assertEquals($properties['position'], $byline->get('position'),
            'Property "position" does not have the expected value');
        $this->assertEquals('special', $byline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $byline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testBylineFromObject()
    {
        $properties = (object)[
            'date' => new \DateTime(),
            'author' => 'John Doe',
            'position' => 'Editorial Chief in Charge',
        ];
        $params = [
            'class' => 'special',
        ];
        $byline = Byline::from($properties, [], $params);

        $this->assertEquals($properties->date, $byline->get('date'),
            'Property "date" does not have the expected value');
        $this->assertEquals($properties->author, $byline->get('author'), 'Property "author" does not have the expected value');
        $this->assertEquals($properties->position, $byline->get('position'), 'Property "position" does not have the expected value');
        $this->assertEquals('special', $byline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $byline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testBylineFromObjectWithMapping()
    {
        $properties = (object)[
            'orig_date' => new \DateTime(),
            'orig_author' => 'John Doe',
            'position' => 'Editorial Chief in Charge',
        ];
        $map = [
            'date' => 'orig_date',
            'author' => 'orig_author',
        ];
        $params = [
            'class' => 'special',
        ];
        $byline = Byline::from($properties, $map, $params);

        $this->assertEquals($properties->orig_date, $byline->get('date'),
            'Property "date" does not have the expected value');
        $this->assertEquals($properties->orig_author, $byline->get('author'),
            'Property "author" does not have the expected value');
        $this->assertEquals($properties->position, $byline->get('position'),
            'Property "position" does not have the expected value');
        $this->assertEquals('special', $byline->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $byline->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testBylineThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $date = new \DateTime();
        $author = 'John Doe';
        $position = 'Editorial Chief in Charge';
        $params = [
            'class' => 'special',
        ];
        $byline = new Byline($date, $author, $position, $params);

        $this->expectException(\Exception::class);
        $byline->get('nonexistent');
    }

    public function testBylineReturnsNullOnAccessOfNonexistentParameter()
    {
        $date = new \DateTime();
        $author = 'John Doe';
        $position = 'Editorial Chief in Charge';
        $params = [
            'class' => 'special',
        ];
        $byline = new Byline($date, $author, $position, $params);

        $this->assertEquals(null, $byline->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testBylineReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $date = new \DateTime();
        $author = 'John Doe';
        $position = 'Editorial Chief in Charge';
        $params = [
            'class' => 'special',
        ];
        $byline = new Byline($date, $author, $position, $params);

        $this->assertEquals('default', $byline->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testBylineCallsVisitorWithByline()
    {
        $date = new \DateTime();
        $author = 'John Doe';
        $position = 'Editorial Chief in Charge';
        $params = [
            'class' => 'special',
        ];
        $byline = new Byline($date, $author, $position, $params);
        $visitor = new Visitor();
        $byline->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Byline',
                $byline
            ],
            $call
        );
    }
}
