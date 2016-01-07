<?php

namespace MJErwin\SendOwl;

use MJErwin\SendOwl\Exception\AuthenticationNotSetException;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class WebHookHelper
{
    protected $data = [];

    public function isSignatureValid()
    {
        $sendowl = SendOwl::instance();

        if (!$sendowl->hasAuthenticationData())
        {
            throw new AuthenticationNotSetException;
        }

        $data = $this->getData();

        $signature = $data['signature'];

        return $sendowl->isSignatureValid($data, $signature);
    }

    public function getData()
    {
        if (empty($this->data))
        {
            $input = $_REQUEST;

            $input_php = json_decode(file_get_contents("php://input"), true);

            if($input_php)
            {
                $input = array_merge($input, $input_php);
            }

            $this->data = $input;
        }

        return $this->data;
    }
}