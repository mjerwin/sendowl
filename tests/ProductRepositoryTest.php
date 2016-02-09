<?php

namespace MJErwin\SendOwl\Tests;

use MJErwin\SendOwl\Api\SendOwlApi;
use MJErwin\SendOwl\Entity\Product;
use MJErwin\SendOwl\Entity\Repository\ProductRepository;
use MJErwin\SendOwl\SendOwl;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class ProductRepositoryTest extends AbstractTestCase
{
    public function testGetProducts()
    {
        $sendowl = SendOwl::instance();

        // Mock the API
        $api = $this->getMockBuilder(SendOwlApi::class)
            ->setMethods(['fetchEntitiesData'])
            ->getMock();

        $mock_data = json_decode(file_get_contents(__DIR__ . '/data/products/response/all.json'), true);
        $api->expects($this->once())->method('fetchEntitiesData')->willReturn($mock_data);

        $sendowl->setApi($api);

        $product_repo = new ProductRepository();
        $products = $product_repo->all();

        // Check we successfully created 2 products
        $this->assertEquals(2, sizeof($products));

        /** @var Product $first_product */
        $first_product = reset($products);

        // Check we have the right object
        $this->assertInstanceOf(Product::class, $first_product);

        // Check all the properties are correct
        // @todo Move to individual tests?
        // @todo Is this necessary, or is it covered by ProductTest?
        $this->assertEquals('https://transactions.sendowl.com/products/12345/ABCD/add_to_cart', $first_product->add_to_cart_url);
        $this->assertEquals('2015-12-13T16:45:55Z', $first_product->created_at);
        $this->assertEquals('GBP', $first_product->currency_code);
        $this->assertEquals(12345, $first_product->id);
        $this->assertEquals('https://transactions.sendowl.com/products/12345/ABCD/purchase', $first_product->instant_buy_url);
        $this->assertEquals('generated', $first_product->license_type);
        $this->assertEquals('Test Product', $first_product->name);
        $this->assertEquals(21.99, $first_product->price);
        $this->assertEquals('https://s3.amazonaws.com/customise.sendowl.com/test.png', $first_product->product_image_url);
        $this->assertEquals('software', $first_product->product_type);
        $this->assertEquals('http://google.co.uk', $first_product->self_hosted_url);
        $this->assertEquals('2016-01-01T12:21:29Z', $first_product->updated_at);
    }

    public function testGetProductsRequest()
    {
        $this->expectRequest('https://www.sendowl.com/api/v1/products.json', 'GET');

        $product_repo = new ProductRepository();
        $products = $product_repo->all();
    }

    public function testGetProduct()
    {
        $sendowl = SendOwl::instance();

        // Mock the API
        $api = $this->getMockBuilder(SendOwlApi::class)
            ->setMethods(['fetchEntityData'])
            ->getMock();

        $mock_data = json_decode(file_get_contents(__DIR__ . '/data/products/response/get.json'), true);
        $api->expects($this->once())->method('fetchEntityData')->willReturn($mock_data);

        $sendowl->setApi($api);

        $product_repo = new ProductRepository();
        $product = $product_repo->get(999);

        $this->assertInstanceOf(Product::class, $product);
    }

    public function testGetProductRequest()
    {
        $this->expectRequest('https://www.sendowl.com/api/v1/products/123.json', 'GET');

        $product_repo = new ProductRepository();
        $products = $product_repo->get(123);
    }

    public function tearDown()
    {
        SendOwl::tearDown();
    }
}