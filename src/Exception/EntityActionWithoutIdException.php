<?php

namespace MJErwin\SendOwl\Exception;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class EntityActionWithoutIdException extends \Exception
{
    /**
     * EntityUpdateWithoutIdException constructor.
     *
     * @param $entity_type
     */
    public function __construct($entity_type, $action)
    {
        $this->message = sprintf('Cannot %s %s because no ID is set.', $action, $entity_type);
    }
}