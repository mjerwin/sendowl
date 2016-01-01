<?php

namespace MJErwin\SendOwl\Exception;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class EntityInvalidException extends \Exception
{
    protected $errors = [];

    public function __construct($entity_type, $errors = [])
    {
        $messages = [];

        foreach($errors as $property => $property_errors)
        {
            foreach($property_errors as $error)
            {
                $messages[] = sprintf('`%s` %s', $property, $error);
            }
        }

        $this->message = sprintf('%s has the following errors: %s', $entity_type, print_r($messages, true));


        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}