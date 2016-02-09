<?php

namespace MJErwin\SendOwl\Tests;

use GuzzleHttp\Psr7\Response;
use MJErwin\SendOwl\Api\SendOwlApi;
use MJErwin\SendOwl\SendOwl;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    protected function expectRequest($endpoint, $method, $data_path = null)
    {
        $api = $this->getMockBuilder(SendOwlApi::class)
            ->setMethods(['performRequest'])
            ->getMock();

        $data = $data_path ? json_decode(file_get_contents($data_path), true) : [];

        $api->expects($this->once())
            ->method('performRequest')
            ->with($endpoint, $data, $method)
            ->willReturn(new Response());

        SendOwl::instance()->setApi($api);

        return $this;
    }
}