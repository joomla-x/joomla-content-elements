<?php

namespace Joomla\Content\Element;

use Joomla\Content\ContentElementInterface;

abstract class AbstractElement implements ContentElementInterface
{
    protected $params = [];

    /**
     * Get the parameters for the element.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->params;
    }

    /**
     * Get a parameter for the content.
     *
     * @param string $key The key
     * @param mixed $default The default value
     *
     * @return mixed
     */
    public function getParameter($key, $default = null)
    {
        return array_key_exists($key, $this->params) ? $this->params[$key] : $default;
    }

    /**
     * Set the parameters.
     *
     * @param $parameters
     */
    public function setParameters($parameters)
    {
        $this->params = $parameters;
    }
}
