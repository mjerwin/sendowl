<?php

namespace MJErwin\SendOwl\Entity\Repository;

use MJErwin\SendOwl\Entity\Product;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class ProductRepository extends AbstractEntityRepository
{
    protected function getEntityClass()
    {
        return Product::class;
    }

    /**
     * @return string
     * @todo Move to entity?
     */
    protected function getResponseRootKey()
    {
        return 'product';
    }
}