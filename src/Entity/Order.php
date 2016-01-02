<?php

namespace MJErwin\SendOwl\Entity;

use MJErwin\SendOwl\Traits\ViewableEntityTrait;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 *
 *
 *
 * @method static Order get(int $id)
 * @method static Order[] all()
 */
class Order extends AbstractEntity
{
    public static $api_endpoint = 'https://www.sendowl.com/api/v1/orders';
    public static $response_root_key = 'order';

    protected $data = [];

    use ViewableEntityTrait;

    /**
     * @return array
     */
    protected function getFieldDefinitions()
    {
        return [
        ];
    }

}