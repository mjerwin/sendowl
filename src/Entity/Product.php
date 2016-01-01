<?php


namespace MJErwin\SendOwl\Entity;
use MJErwin\SendOwl\SendOwl;


/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class Product extends AbstractEntity
{
    protected $data;

    public static function all()
    {
        $list = SendOwl::instance()->listEntities(self::class);
    }
}