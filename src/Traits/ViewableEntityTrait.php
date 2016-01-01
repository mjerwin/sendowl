<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 01/01/2016
 * Time: 11:14
 */

namespace MJErwin\SendOwl\Traits;

use MJErwin\SendOwl\SendOwl;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
trait ViewableEntityTrait
{
    public static function all()
    {
        $entity_class = self::class;

        $data = SendOwl::instance()->fetchEntitiesData($entity_class);

        $items = [];

        foreach($data as $item_data)
        {
            if (self::$response_root_key)
            {
                $item_data = $item_data[self::$response_root_key];
            }

            $items[] = new $entity_class($item_data);
        }

        return $items;
    }

    public static function get($id)
    {
        $entity_class = self::class;

        $data = SendOwl::instance()->fetchEntityData($entity_class, $id);

        if (self::$response_root_key)
        {
            $data = $data[self::$response_root_key];
        }

        return new $entity_class($data);
    }
}