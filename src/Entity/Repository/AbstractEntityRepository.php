<?php

namespace MJErwin\SendOwl\Entity\Repository;

use MJErwin\SendOwl\Entity\AbstractEntity;
use MJErwin\SendOwl\SendOwl;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
abstract class AbstractEntityRepository
{
    abstract protected function getEntityClass();
    abstract protected function getResponseRootKey();

    /**
     * @return AbstractEntity[]
     */
    public function all()
    {
        $entity_class = $this->getEntityClass();

        $data = SendOwl::instance()->fetchEntitiesData($entity_class);

        $items = [];

        foreach($data as $item_data)
        {
            if ($this->getResponseRootKey())
            {
                $item_data = $item_data[$this->getResponseRootKey()];
            }

            $items[] = new $entity_class($item_data);
        }

        return $items;
    }

    /**
     * @return AbstractEntity
     */
    public function get($id)
    {
        $entity_class = $this->getEntityClass();

        $data = SendOwl::instance()->fetchEntityData($entity_class, $id);

        if ($this->getResponseRootKey())
        {
            $data = $data[$this->getResponseRootKey()];
        }

        return new $entity_class($data);
    }
}