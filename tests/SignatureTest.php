<?php
use MJErwin\SendOwl\SendOwl;


/**
 * @author Matthew Erwin <m@tthewerwin.com>
 * www.matthewerwin.co.uk
 */
class SignatureTest extends PHPUnit_Framework_TestCase
{
    public function testSignatureValidation()
    {
        $sendowl = SendOwl::instance();

        // Test using example data from http://help.sendowl.com/article/110-signed-urls
        $sendowl->authenticate('publicStr', 't0ps3cr3t');

        parse_str('order_id=12345&buyer_name=Test+Man&buyer_email=test%40test.com&product_id=123&signature=QpIEZjEmEMZV%2FHYtinoOj5bqAFw%3D', $request_data);
        $signature = 'QpIEZjEmEMZV/HYtinoOj5bqAFw=';

        $valid_signature = $sendowl->isSignatureValid($request_data, $signature);

        $this->assertTrue($valid_signature);
    }
}