<?php

namespace MJErwin\SendOwl\Tests;

use GuzzleHttp\Psr7\Response;
use MJErwin\SendOwl\Entity\Product;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class ProductTest extends AbstractTestCase
{

    /**
     * @dataProvider providerAttributeData
     */
    public function testConstructSetsData($data)
    {
        $product = new Product($data);

        $attr = key($data);

        $this->assertEquals(reset($data), $product->{$attr});
    }

    /**
     * @dataProvider providerAttributeData
     */
    public function testSetterSetsData($data)
    {
        $product = new Product($data);

        $attr = key($data);

        $product->{$attr} = reset($data);

        $this->assertEquals(reset($data), $product->{$attr});
    }

    public function providerAttributeData()
    {
        return [
            [['id' => 99]],
            [['product_type' => 'type']],
            [['name' => 'Test Name']],
            [['attachment' => 'Test Attachment']],
            [['price' => 99.99]],
            [['pdf_stamping' => true]],
            [['sales_limit' => 10]],
            [['self_hosted_url' => 'www.google.co.uk']],
            [['license_type' => 'generated']],
            [['license_fetch_url' => 'www.google.co.uk']],
            [['shopify_variant_id' => 25]],
            [['custom_field' => 'www.lego.com']],
            [['override_currency_code' => 'GB']],
            [['currency_code' => 'GB']],
            [['product_image_url' => 'www.google.co.uk']],
            [['instant_buy_url' => 'www.google.co.uk']],
            [['add_to_cart_url' => 'www.google.co.uk']],
            [['created_at' => '2015-10-21 04:29']],
            [['updated_at' => '2015-10-21 04:29']],
        ];
    }

    /**
     * Check the product create request
     */
    public function testCreateRequest()
    {
        $this->expectRequest('https://www.sendowl.com/api/v1/products.json', 'POST', __DIR__ . '/data/products/request/create.json');

        $product = new Product();
        $product->name = 'Test Product';
        $product->create();
    }

    /**
     * Check the product delete request
     */
    public function testDeleteRequest()
    {
        $this->expectRequest('https://www.sendowl.com/api/v1/products/999.json', 'DELETE');

        $product = new Product();
        $product->id = 999;
        $product->delete();
    }

    public function testUpdateRequest()
    {
        $this->expectRequest('https://www.sendowl.com/api/v1/products/999.json', 'PUT', __DIR__ . '/data/products/request/update.json');

        $product = new Product();
        $product->id = 999;
        $product->name = 'Updated Product';
        $product->update();
    }
}