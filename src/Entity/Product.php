<?php

namespace MJErwin\SendOwl\Entity;

use MJErwin\SendOwl\Traits\CreatableEntityTrait;
use MJErwin\SendOwl\Traits\DeletableEntityTrait;
use MJErwin\SendOwl\Traits\UpdatableEntityTrait;
use MJErwin\SendOwl\Traits\ViewableEntityTrait;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 *
 * @property int|null    $id
 * @property string|null $product_type
 * @property string|null $name
 * @property array|null  $attachment
 * @property double|null $price
 * @property bool|null   $pdf_stamping
 * @property int|null    $sales_limit
 * @property string|null $self_hosted_url
 * @property string|null $license_type
 * @property string|null $license_fetch_url
 * @property string|null $shopify_variant_id
 * @property string|null $custom_field
 * @property string|null $override_currency_code
 * @property string|null $currency_code
 * @property string|null $product_image_url
 * @property string|null $instant_buy_url
 * @property string|null $add_to_cart_url
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 *
 * @method static Product get(int $id)
 * @method static Product[] all()
 */
class Product extends AbstractEntity
{
    public static $api_endpoint = 'https://www.sendowl.com/api/v1/products';
    public static $response_root_key = 'product';

    protected $data = [];

    use ViewableEntityTrait;
    use UpdatableEntityTrait;
    use CreatableEntityTrait;
    use DeletableEntityTrait;

    /**
     * @return array
     */
    protected function getFieldDefinitions()
    {
        return [
            'id' => [
                'read' => true,
                'write' => false,
            ],
            'product_type' => [
                'read' => true,
                'write' => true,
            ],
            'name' => [
                'read' => true,
                'write' => true,
            ],
            'attachment' => [
                'read' => true,
                'write' => false,
            ],
            'price' => [
                'read' => true,
                'write' => true,
            ],
            'pdf_stamping' => [
                'read' => true,
                'write' => true,
            ],
            'sales_limit' => [
                'read' => true,
                'write' => true,
            ],
            'self_hosted_url' => [
                'read' => true,
                'write' => true,
            ],
            'license_type' => [
                'read' => true,
                'write' => true,
            ],
            'license_fetch_url' => [
                'read' => true,
                'write' => true,
            ],
            'shopify_variant_id' => [
                'read' => true,
                'write' => true,
            ],
            'custom_field' => [
                'read' => true,
                'write' => true,
            ],
            'override_currency_code' => [
                'read' => false,
                'write' => true,
            ],
            'currency_code' => [
                'read' => true,
                'write' => false,
            ],
            'product_image_url' => [
                'read' => true,
                'write' => false,
            ],
            'instant_buy_url' => [
                'read' => true,
                'write' => false,
            ],
            'add_to_cart_url' => [
                'read' => true,
                'write' => false,
            ],
            'created_at' => [
                'read' => true,
                'write' => false,
            ],
            'updated_at' => [
                'read' => true,
                'write' => false,
            ],
        ];
    }

}