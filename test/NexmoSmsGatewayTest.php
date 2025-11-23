<?php

namespace Masum\SmsGateway\UnitTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nexmo\Client;

class NexmoSmsGatewayTest extends TestCase
{

    /**
     * Test the send sms response status
     *
     * @return void
     */
    public function testSendSmsStatus()
    {

        $objGateWay = new \Masum\SmsGateway\NexmoSmsGateway();
        $objSMS = new \Masum\SmsGateway\SmsGateway($objGateWay);
        $response = $objSMS->sendSms('+1711122288', 'Hello');
        $responseStatus = $response['status'];
        $this->assertEquals(0, $responseStatus);

    }

    /**
     * test the sms price...
     */
    public function testSmsMessagePrice()
    {

        $objGateWay = new \Masum\SmsGateway\NexmoSmsGateway();
        $objSMS = new \Masum\SmsGateway\SmsGateway($objGateWay);
        $response = $objSMS->sendSms('+1711122288', 'Hello');
        $messagePrice = $response['message-price'];
        $this->assertEquals(0.05100000, $messagePrice);

    }

    /**
     * test the response data object
     */
    public function testSendSmsResponse()
    {
        $objGateWay = new \Masum\SmsGateway\NexmoSmsGateway();
        $objSMS = new \Masum\SmsGateway\SmsGateway($objGateWay);
        $objSMS->sendSms('+1711122288', 'Hello');
        $responseDataObject = $objSMS->getResponseData();
        $this->assertInstanceOf(\Masum\SmsGateway\ResponseData::class, $responseDataObject);
    }
}
