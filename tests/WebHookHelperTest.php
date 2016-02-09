<?php

namespace MJErwin\SendOwl\Tests;

use MJErwin\SendOwl\Exception\AuthenticationNotSetException;
use MJErwin\SendOwl\SendOwl;
use MJErwin\SendOwl\WebHookHelper;

/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class WebHookHelperTest extends AbstractTestCase
{
    public function testNoAuthenticationException()
    {
        $this->setExpectedException(AuthenticationNotSetException::class);

        $webhook_helper = new WebHookHelper();

        $webhook_helper->isSignatureValid();
    }

    public function tearDown()
    {
        SendOwl::tearDown();
    }
}