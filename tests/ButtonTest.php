<?php

namespace Joomla\Tests\Content;

use Joomla\Content\Element\Button;
use Joomla\Tests\Content\Mock\Visitor;

class ButtonTest extends \PHPUnit\Framework\TestCase
{
    public function testButtonConstructor()
    {
        $label = 'Foo';
        $url = 'action.php';
        $hint = 'Send Mail';
        $icon = 'mail';
        $params = [
            'class' => 'special',
        ];
        $button = new Button($label, $url, $hint, $icon, $params);

        $this->assertEquals($label, $button->get('label'), 'Property "label" does not have the expected value');
        $this->assertEquals($url, $button->get('url'), 'Property "url" does not have the expected value');
        $this->assertEquals($hint, $button->get('hint'), 'Property "hint" does not have the expected value');
        $this->assertEquals($icon, $button->get('icon'), 'Property "icon" does not have the expected value');
        $this->assertEquals('special', $button->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $button->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testButtonFromArray()
    {
        $properties = [
            'label' => 'Foo',
            'url' => 'action.php',
            'icon' => 'mail',
        ];
        $params = [
            'class' => 'special',
        ];
        $button = Button::from($properties, [], $params);

        $this->assertEquals($properties['label'], $button->get('label'),
            'Property "label" does not have the expected value');
        $this->assertEquals($properties['url'], $button->get('url'), 'Property "url" does not have the expected value');
        $this->assertEquals($properties['icon'], $button->get('icon'),
            'Property "icon" does not have the expected value');
        $this->assertEquals('special', $button->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $button->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testButtonFromArrayWithMapping()
    {
        $properties = [
            'orig_label' => 'Foo',
            'orig_url' => 'action.php',
            'icon' => 'mail',
        ];
        $map = [
            'label' => 'orig_label',
            'url' => 'orig_url',
        ];
        $params = [
            'class' => 'special',
        ];
        $button = Button::from($properties, $map, $params);

        $this->assertEquals($properties['orig_label'], $button->get('label'),
            'Property "label" does not have the expected value');
        $this->assertEquals($properties['orig_url'], $button->get('url'),
            'Property "url" does not have the expected value');
        $this->assertEquals($properties['icon'], $button->get('icon'),
            'Property "icon" does not have the expected value');
        $this->assertEquals('special', $button->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $button->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testButtonFromObject()
    {
        $properties = (object)[
            'label' => 'Foo',
            'url' => 'action.php',
            'icon' => 'mail',
        ];
        $params = [
            'class' => 'special',
        ];
        $button = Button::from($properties, [], $params);

        $this->assertEquals($properties->label, $button->get('label'),
            'Property "label" does not have the expected value');
        $this->assertEquals($properties->url, $button->get('url'), 'Property "url" does not have the expected value');
        $this->assertEquals($properties->icon, $button->get('icon'),
            'Property "icon" does not have the expected value');
        $this->assertEquals('special', $button->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $button->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testButtonFromObjectWithMapping()
    {
        $properties = (object)[
            'orig_label' => 'Foo',
            'orig_url' => 'action.php',
            'icon' => 'mail',
        ];
        $map = [
            'label' => 'orig_label',
            'url' => 'orig_url',
        ];
        $params = [
            'class' => 'special',
        ];
        $button = Button::from($properties, $map, $params);

        $this->assertEquals($properties->orig_label, $button->get('label'),
            'Property "label" does not have the expected value');
        $this->assertEquals($properties->orig_url, $button->get('url'),
            'Property "url" does not have the expected value');
        $this->assertEquals($properties->icon, $button->get('icon'),
            'Property "icon" does not have the expected value');
        $this->assertEquals('special', $button->getParameter('class'),
            'Parameter "class" does not have the expected value');

        $this->assertEquals($params, $button->getParameters(), 'Parameter array does not have the expected values');
    }

    public function testButtonThrowsExceptionOnAccessOfNonexistentProperty()
    {
        $label = 'Foo';
        $url = 'action.php';
        $hint = 'Send Mail';
        $icon = 'mail';
        $params = [
            'class' => 'special',
        ];
        $button = new Button($label, $url, $hint, $icon, $params);

        $this->expectException(\Exception::class);
        $button->get('nonexistent');
    }

    public function testButtonReturnsNullOnAccessOfNonexistentParameter()
    {
        $label = 'Foo';
        $url = 'action.php';
        $hint = 'Send Mail';
        $icon = 'mail';
        $params = [
            'class' => 'special',
        ];
        $button = new Button($label, $url, $hint, $icon, $params);

        $this->assertEquals(null, $button->getParameter('unknown'), 'Unknown parameter does not return null');
    }

    public function testButtonReturnsDefaultOnAccessOfNonexistentParameterIfProvided()
    {
        $label = 'Foo';
        $url = 'action.php';
        $hint = 'Send Mail';
        $icon = 'mail';
        $params = [
            'class' => 'special',
        ];
        $button = new Button($label, $url, $hint, $icon, $params);

        $this->assertEquals('default', $button->getParameter('unknown', 'default'),
            'Unknown parameter with default does not return default');
    }

    public function testButtonCallsVisitorWithButton()
    {
        $label = 'Foo';
        $url = 'action.php';
        $hint = 'Send Mail';
        $icon = 'mail';
        $params = [
            'class' => 'special',
        ];
        $button = new Button($label, $url, $hint, $icon, $params);
        $visitor = new Visitor();
        $button->accept($visitor);

        $calls = $visitor->calls['visit'];
        $this->assertEquals(1, count($calls));
        $call = array_values($calls[0]);
        $this->assertEquals(
            [
                'Button',
                $button
            ],
            $call
        );
    }
}
