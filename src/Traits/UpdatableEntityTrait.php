<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 01/01/2016
 * Time: 11:21
 */

namespace MJErwin\SendOwl\Traits;

use MJErwin\SendOwl\Exception\EntityActionWithoutIdException;
use MJErwin\SendOwl\SendOwl;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
trait UpdatableEntityTrait
{
    public function update()
    {
        $entity_class = self::class;

        $data = $this->data;

        $field_definitions = $this->getFieldDefinitions();

        // Filter out fields that are not writable
        $data = array_filter($data, function ($k) use ($field_definitions)
        {
            $writable = isset($field_definitions[$k]['write']) ? $field_definitions[$k]['write'] : false;

            return $writable ? true : false;
        }, ARRAY_FILTER_USE_KEY);


        if (!$this->id)
        {
            throw new EntityActionWithoutIdException($entity_class, 'update');
        }

        if (self::$response_root_key)
        {
            $data = [self::$response_root_key => $data];
        }

        SendOwl::instance()->updateEntity($entity_class, $this->id, $data);

        // @todo Check response and return result
    }
}