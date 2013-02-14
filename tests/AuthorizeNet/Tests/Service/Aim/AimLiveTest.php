<?php

/*
 * This file is part of the AuthorizeNet PHP-SDK package.
 *
 * For the full copyright and license information, please view the License.pdf
 * file that was distributed with this source code.
 */

use AuthorizeNet\Service\Aim\Request;

class AimLiveTest extends \PHPUnit_Framework_TestCase
{
    public function testAuthCaptureSetECheckMethod()
    {
        if (MERCHANT_LIVE_API_LOGIN_ID) {
            // $this->markTestIncomplete('Depends on whether eChecks is enabled');
            $sale = new Request(MERCHANT_LIVE_API_LOGIN_ID,MERCHANT_LIVE_TRANSACTION_KEY);
            $sale->setSandbox(false);
            $sale->test_request = 'TRUE';
            $sale->amount = "4.99";
            $sale->setECheck(
                '121042882',
                '123456789123',
                'CHECKING',
                'Bank of Earth',
                'Jane Doe',
                'WEB'
            );
            $response = $sale->authorizeAndCapture();
            $this->assertEquals("ECHECK", $response->method);
            $this->assertEquals("18", $response->response_reason_code);
            // $this->assertTrue($response->approved);
        }
    }

    public function testAuthCaptureECheck()
    {
        if (MERCHANT_LIVE_API_LOGIN_ID) {
            // $this->markTestIncomplete('Depends on whether eChecks is enabled');
            $sale = new Request(MERCHANT_LIVE_API_LOGIN_ID,MERCHANT_LIVE_TRANSACTION_KEY);
            $sale->setSandbox(false);
            $sale->test_request = 'TRUE';
            $sale->setFields(
                array(
                'amount' => rand(1, 1000),
                'method' => 'echeck',
                'bank_aba_code' => '121042882',
                'bank_acct_num' => '123456789123',
                'bank_acct_type' => 'CHECKING',
                'bank_name' => 'Bank of Earth',
                'bank_acct_name' => 'Jane Doe',
                'echeck_type' => 'WEB',
                )
            );
            $response = $sale->authorizeAndCapture();
            $this->assertEquals("ECHECK", $response->method);
            $this->assertEquals("18", $response->response_reason_code);
            // $this->assertTrue($response->approved);
        }
    }

    public function testAuthCaptureLiveServerTestRequest()
    {
        if (MERCHANT_LIVE_API_LOGIN_ID) {
            $sale = new Request(MERCHANT_LIVE_API_LOGIN_ID,MERCHANT_LIVE_TRANSACTION_KEY);
            $sale->setSandbox(false);
            $sale->setFields(
                array(
                'amount' => rand(1, 1000),
                'card_num' => '6011000000000012',
                'exp_date' => '0415'
                )
            );
            $sale->setField('test_request', 'TRUE');
            $response = $sale->authorizeAndCapture();
            $this->assertTrue($response->approved);
        }
    }

    public function testAuthCaptureLiveServer()
    {
        if (MERCHANT_LIVE_API_LOGIN_ID) {
            $sale = new Request(MERCHANT_LIVE_API_LOGIN_ID,MERCHANT_LIVE_TRANSACTION_KEY);
            $sale->setSandbox(false);
            $sale->test_request = 'TRUE';
            $sale->setFields(
                array(
                'amount' => rand(1, 1000),
                'card_num' => '6011000000000012',
                'exp_date' => '0415'
                )
            );
            $response = $sale->authorizeAndCapture();
            $this->assertTrue($response->approved);
        }
    }

    public function testInvalidCredentials()
    {
        if (MERCHANT_LIVE_API_LOGIN_ID) {
            // Post a response to live server using invalid credentials.
            $sale = new Request('a','a');
            $sale->setSandbox(false);
            $sale->setFields(
                array(
                'amount' => rand(1, 1000),
                'card_num' => '6011000000000012',
                'exp_date' => '0415'
                )
            );
            $response = $sale->authorizeAndCapture();
            $this->assertTrue($response->error);
            $this->assertEquals("13", $response->response_reason_code);
        }
    }
}
