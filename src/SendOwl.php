<?php


namespace MJErwin\SendOwl;


/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class SendOwl
{
    protected static $instance;

    /**
     * SendOwl constructor.
     */
    private function __construct()
    {

    }

    public static function instance()
    {
        if (!self::$instance instanceof SendOwl)
        {
            self::$instance = new SendOwl();
        }

        return self::$instance;
    }

    public function listEntities($entity_type)
    {

    }
}