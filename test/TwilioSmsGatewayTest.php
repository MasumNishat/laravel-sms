<?php

namespace Masum\SmsGateway\UnitTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TwilioSmsGatewayTest extends TestCase
{

    /**
     * test the response data object
     */
    public function testSendSmsResponse()
    {
        $objTGateWay = new \Masum\SmsGateway\TwilioSmsGateway();
        $objSMST = new \Masum\SmsGateway\SmsGateway($objTGateWay);
        $objSMST->sendSms('+1711840760', 'Hello Twilio');
        $responseDataObject = $objSMST->getResponseData();
        $this->assertInstanceOf(\Masum\SmsGateway\ResponseData::class, $responseDataObject);
    }
}
