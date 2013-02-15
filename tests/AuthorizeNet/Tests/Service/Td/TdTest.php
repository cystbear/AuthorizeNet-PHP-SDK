<?php

/*
 * This file is part of the AuthorizeNet PHP-SDK package.
 *
 * For the full copyright and license information, please view the License.pdf
 * file that was distributed with this source code.
 */

use AuthorizeNet\Service\Aim\Request as AimRequest;
use AuthorizeNet\Service\Td\Request;

class TdTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSettledBatchList()
    {
        $request = new Request();
        $response = $request->getSettledBatchList();
        $this->assertTrue($response->isOk());
        $this->assertEquals("I00001",(string) array_pop($response->xpath("messages/message/code")));
    }

    public function testGetSettledBatchListIncludeStatistics()
    {
        $request = new Request();
        $response = $request->getSettledBatchList(true);
        $this->assertTrue($response->isOk());
    }

    public function testGetSettledBatchListForMonth()
    {
        $request = new Request();
        $response = $request->getSettledBatchListForMonth();
        $this->assertTrue($response->isOk());
    }

    public function testGetTransactionsForDay()
    {
        $request = new Request();
        $transactions = $request->getTransactionsForDay(12, 8, 2010);
        $this->assertTrue(is_array($transactions));
    }

    public function testGetTransactionList()
    {
        $request = new Request();
        $response = $request->getSettledBatchList();
        $this->assertTrue($response->isOk());
        $batches = $response->xpath("batchList/batch");
        $batch_id = (string) $batches[0]->batchId;
        $response = $request->getTransactionList($batch_id);
        $this->assertTrue($response->isOk());
    }

    public function testGetTransactionDetails()
    {
        $sale = new AimRequest();
        $amount = rand(1, 100);
        $response = $sale->authorizeAndCapture($amount, '4012888818888', '04/17');
        $this->assertTrue($response->approved);

        $transId = $response->transaction_id;

        $request = new Request();
        $response = $request->getTransactionDetails($transId);
        $this->assertTrue($response->isOk());

        $this->assertEquals($transId, (string) $response->xml->transaction->transId);
        $this->assertEquals($amount, (string) $response->xml->transaction->authAmount);
        $this->assertEquals("Visa", (string) $response->xml->transaction->payment->creditCard->cardType);

    }

    public function testGetUnsettledTransactionList()
    {
        $sale = new AimRequest();
        $amount = rand(1, 100);
        $response = $sale->authorizeAndCapture($amount, '4012888818888', '04/17');
        $this->assertTrue($response->approved);

        $request = new Request();
        $response = $request->getUnsettledTransactionList();
        $this->assertTrue($response->isOk());
        $this->assertTrue($response->xml->transactions->count() >= 1);
    }

    public function testGetBatchStatistics()
    {
        $request = new Request();
        $response = $request->getSettledBatchList();
        $this->assertTrue($response->isOk());
        $this->assertTrue($response->xml->batchList->count() >= 1);
        $batchId = $response->xml->batchList->batch[0]->batchId;

        $request = new Request();
        $response = $request->getBatchStatistics($batchId);
        $this->assertTrue($response->isOk());
    }

}
