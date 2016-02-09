<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 01/01/2016
 * Time: 12:22
 */

namespace MJErwin\SendOwl\Traits;

use MJErwin\SendOwl\Exception\EntityActionWithoutIdException;
use MJErwin\SendOwl\SendOwl;

/**
 * @author Matthew Erwin <matthew.j.erwin@me.com>
 * www.matthewerwin.co.uk
 */
trait DeletableEntityTrait
{
    public function delete()
    {
        $entity_class = get_called_class();

        if (!$this->id)
        {
            throw new EntityActionWithoutIdException($entity_class, 'delete');
        }
        
        SendOwl::instance()->deleteEntity($entity_class, $this->id);

        // @todo Check response and return result
    }
}