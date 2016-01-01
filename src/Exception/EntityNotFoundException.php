<?php

namespace MJErwin\SendOwl\Exception;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class EntityNotFoundException extends \Exception
{
    public function __construct($entity_type, $id)
    {
        $this->message = sprintf('%s with ID #%s could not be found', $entity_type, $id);
    }
}