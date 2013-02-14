<?php

/*
 * This file is part of the AuthorizeNet PHP-SDK package.
 *
 * For the full copyright and license information, please view the License.pdf
 * file that was distributed with this source code.
 */
class SslTest extends \PHPUnit_Framework_TestCase
{
    public function testSandboxSSLCertIsValid()
    {
        exec("echo | openssl s_client -connect test.authorize.net:443 -showcerts -verify 10 -CAfile ../../../src/AuthorizeNet/Common/ssl/cert.pem 2>&1", $output, $return_value);
        $this->assertEquals(0, $return_value);
        $this->assertTrue(in_array('Verify return code: 0 (ok)', array_map('trim', $output)));
        exec("echo | openssl s_client -connect apitest.authorize.net:443 -showcerts -verify 10 -CAfile ../../../src/AuthorizeNet/Common/ssl/cert.pem 2>&1", $output, $return_value);
        $this->assertEquals(0, $return_value);
        $this->assertTrue(in_array('Verify return code: 0 (ok)', array_map('trim', $output)));
    }

    public function testLiveSSLCertIsValid()
    {
        exec("echo | openssl s_client -connect secure.authorize.net:443 -showcerts -verify 10 -CAfile ../../../src/AuthorizeNet/Common/ssl/cert.pem 2>&1", $output, $return_value);
        $this->assertEquals(0, $return_value);
        $this->assertTrue(in_array('Verify return code: 0 (ok)', array_map('trim', $output)));
        exec("echo | openssl s_client -connect api.authorize.net:443 -showcerts -verify 10 -CAfile ../../../src/AuthorizeNet/Common/ssl/cert.pem 2>&1", $output, $return_value);
        $this->assertEquals(0, $return_value);
        $this->assertTrue(in_array('Verify return code: 0 (ok)', array_map('trim', $output)));
    }
}
