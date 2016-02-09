<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 01/01/2016
 * Time: 12:51
 */

namespace MJErwin\SendOwl\Traits;

use MJErwin\SendOwl\SendOwl;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
trait CreatableEntityTrait
{
    abstract public function getFieldDefinitions();

    public function create()
    {
        $entity_class = get_called_class();

        $data = $this->data;

        $field_definitions = $this->getFieldDefinitions();

        // Filter out fields that are not writable
        $data = array_filter($data, function ($k) use ($field_definitions)
        {
            $writable = isset($field_definitions[$k]['write']) ? $field_definitions[$k]['write'] : false;

            return $writable ? true : false;
        }, ARRAY_FILTER_USE_KEY);


        if (self::$response_root_key)
        {
            $data = [self::$response_root_key => $data];
        }

        $data = SendOwl::instance()->createEntity($entity_class, $data);

        $this->setData($data);

        // @todo Check response and return result
    }
}