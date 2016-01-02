<?php

namespace MJErwin\SendOwl\Exception;

use Exception;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class AuthenticationNotSetException extends \Exception
{
    public function __construct($message = null, $code, Exception $previous)
    {
        if(!$message)
        {
            $message = 'SendOwl authentication data not set';
        }

        parent::__construct($message, $code, $previous);
    }

}