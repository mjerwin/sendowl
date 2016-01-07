<?php
use MJErwin\SendOwl\Entity\Product;


/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class ProductTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerConstructData
     */
    public function testConstructSetsData($data)
    {
        $product = new Product($data);

        $attr = key($data);
        
        $this->assertEquals(reset($data), $product->{$attr});
    }

    /**
     * @dataProvider providerConstructData
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
}