<?php

namespace MJErwin\SendOwl\Entity;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
abstract class AbstractEntity
{
    public static $api_endpoint;
    public static $response_root_key;

    protected $data;

    /**
     * AbstractEntity constructor.
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->setData($data);

        return $this;
    }

    protected function setData($data = [])
    {
        $called_class = get_called_class();
        $response_root_key = $called_class::$response_root_key;

        // Check for data inside a root element.
        if (sizeof($data) == 1 && key($data) == $response_root_key)
        {
            $data = $data[$response_root_key];
        }

        $default_values = array_fill_keys(array_keys($this->getFieldDefinitions()), null);

        $this->data = array_merge($default_values, $data ?: []);

        return $this;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    function __get($name)
    {
        if (array_key_exists($name, $this->data))
        {
            return $this->data[$name];
        }
        else
        {
            trigger_error(sprintf('Undefined property: %s::$%s', get_called_class(), $name));
        }
    }

    /**
     * @param $name
     * @param $value
     */
    function __set($name, $value)
    {
        if (array_key_exists($name, $this->data))
        {
            $this->data[$name] = $value;
        }
        else
        {
            trigger_error(sprintf('Undefined property: %s::$%s', get_called_class(), $name));
        }
    }

    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    abstract protected function getFieldDefinitions();
}