<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 15/01/2016
 * Time: 21:18
 */

namespace MJErwin\SendOwl\Api;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
interface SendOwlApiInterface
{
    public function authenticate($api_key, $api_secret);

    public function fetchEntitiesData($entity_type);

    public function fetchEntityData($entity_type, $id);

    public function updateEntity($entity_type, $id, $data);

    public function createEntity($entity_type, $data);

    public function deleteEntity($entity_type, $id);
}