<?php

use AuthorizeNet\Service\Dpm\Form as DpmForm;

class DpmTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateFingerprint()
    {
        $this->assertEquals("db88bbebb8f699acdbe70daad897a68a",DpmForm::getFingerprint("123","123","123","123","123"));
    }

    public function testGetCreditCardForm()
    {
        $fp_sequence = "12345";
        $this->assertContains('<input type="hidden" name="x_fp_sequence" value="'.$fp_sequence.'">',DpmForm::getCreditCardForm('2', $fp_sequence, 'ht', '2', '1', true));
    }

    public function testRelayResponseUrl()
    {
        $return_url = 'http://yourdomain.com';

        $this->assertContains('window.location="'.$return_url.'";', DpmForm::getRelayResponseSnippet($return_url));
    }

}
