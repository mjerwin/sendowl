<?php

namespace MJErwin\SendOwl\Tests;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use MJErwin\SendOwl\Entity\Product;
use MJErwin\SendOwl\SendOwl;
use MJErwin\SendOwl\Exception\EntityNotFoundException;
use MJErwin\SendOwl\Api\SendOwlApi;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class SendOwlApiTest extends AbstractTestCase
{
    public function testDeletingInvalidEntityThrowsException()
    {
        $this->setExpectedException(EntityNotFoundException::class);

        $sendowl = SendOwl::instance();

        // Mock the API
        $api = $this->getMockBuilder(SendOwlApi::class)
            ->setMethods(['performRequest'])
            ->getMock();

        // Mock the response with a 404 status code
        $response = $this->getMockBuilder(Response::class)->getMock();
        $response->method('getStatusCode')->willReturn(404);

        $api->expects($this->once())
            ->method('performRequest')
            ->will($this->throwException(new ClientException(null, new Request('x', 'y'), $response)));

        $sendowl->setApi($api);

        $sendowl->deleteEntity(Product::class, 1);
    }

    public function tearDown()
    {
        SendOwl::tearDown();
    }
}