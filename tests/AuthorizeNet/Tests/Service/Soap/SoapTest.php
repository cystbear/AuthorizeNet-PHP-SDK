<?php

/*
 * This file is part of the AuthorizeNet PHP-SDK package.
 *
 * For the full copyright and license information, please view the License.pdf
 * file that was distributed with this source code.
 */

use AuthorizeNet\Service\Soap\Client;

class SoapTest extends \PHPUnit_Framework_TestCase
{
    public function testSaveSoapDoc ()
    {
        $filepath = dirname(__FILE__) . "/soap_doc.php";
        $client = new Client();
        $this->assertTrue($client->saveSoapDocumentation($filepath) > 1);
        unlink($filepath);
    }

    public function testGetCustomerIds ()
    {
        $client = new Client();
        $result = $client->GetCustomerProfileIds(
            array(
                'merchantAuthentication' => array(
                    'name' => AUTHORIZENET_API_LOGIN_ID,
                    'transactionKey' => AUTHORIZENET_TRANSACTION_KEY,
                ),
            )
        );
        $customer_ids = $result->GetCustomerProfileIdsResult->ids->long;
        $this->assertTrue(is_array($customer_ids));
    }

}
