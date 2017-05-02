<?php
namespace Joomla\Tests\Content\Mock;

use Joomla\Content\ContentElementInterface;
use Joomla\Content\ContentVisitorInterface;

class Visitor implements ContentVisitorInterface
{
    public $calls = [];

    /**
     * Process the content.
     *
     * @param string $elementName The name of the content element
     * @param ContentElementInterface $content The content
     */
    public function visit($elementName, ContentElementInterface $content)
    {
        $this->calls[__FUNCTION__][] = [
            'elementName' => $elementName,
            'content' => $content,
        ];
    }

    /**
     * Register a content element.
     *
     * @param string $elementName The name of the content element
     * @param callable|array|string $handler The handler for that element
     */
    public function registerContentType($elementName, $handler)
    {
        $this->calls[__FUNCTION__][] = [
            'elementName' => $elementName,
            'handler' => $handler,
        ];
    }
}
