<?php
/**
 * The Sms Gateway to send SMS through various providers.
 * It supports multiple sms gateways, and easily extendable to support new gateways.
 *
 * PHP version 7.1
 *
 * @category PHP/Laravel
 * @package  Masum_SmsGateway
 * @author   Masum Nishat <masum.nishat21@gmail.com>
 * @link     https://github.com/MasumNishat/laravel-sms
 */
namespace Masum\SmsGateway;

use Illuminate\Support\Facades\Http;

/**
 * BulkSmsBdGateway The class to send sms using BulkSMS Bangladesh API
 *
 * @category BulkSmsBdGateway
 * @package  Masum_SmsGateway
 * @author   Masum Nishat <masum.nishat21@gmail.com>
 * @link     https://github.com/MasumNishat/laravel-sms
 */
class BulkSmsBdGateway implements SmsGatewayInterface
{
    protected $apiKey;

    protected $senderId;

    private $_response;

    /**
     * The class constructor
     */
    public function __construct()
    {
        $this->apiKey = config('sms_gateway.bulksmsbd_sms_api_settings.API_KEY');
        $this->senderId = config('sms_gateway.bulksmsbd_sms_api_settings.SENDER_ID');
    }

    /**
     * The function to send sms using BulkSMS Bangladesh API
     *
     * @param String $smsTo   The recipient number
     * @param String $message The sms message
     *
     * @return mixed The response from API
     */
    public function send($smsTo, $message)
    {
        // Remove + and country code prefix for BulkSMSBD (expects 11 digit BD number)
        $phoneNumber = ltrim($smsTo, '+');
        if (str_starts_with($phoneNumber, '88')) {
            $phoneNumber = substr($phoneNumber, 2);
        }

        $response = Http::asMultipart()->post('http://bulksmsbd.net/api/smsapi', [
            [
                'name' => 'api_key',
                'contents' => $this->apiKey,
            ],
            [
                'name' => 'type',
                'contents' => 'text',
            ],
            [
                'name' => 'number',
                'contents' => $phoneNumber,
            ],
            [
                'name' => 'senderid',
                'contents' => $this->senderId,
            ],
            [
                'name' => 'message',
                'contents' => $message,
            ],
        ]);

        $this->_response = $response->json();

        if (!$response->successful() || ($this->_response['response_code'] ?? null) != 202) {
            throw new \Exception('BulkSMSBD API error: ' . ($this->_response['error_message'] ?? $response->body()));
        }

        return $this->_response;
    }

    /**
     * The function to get response from BulkSMS Bangladesh API
     *
     * @return ResponseData
     */
    public function getResponseData(): ResponseData
    {
        $objResponseData = new ResponseData();
        if (isset($this->_response)) {
            $objResponseData->setStatus($this->_response['response_code'] ?? 'unknown');
            $objResponseData->setMessageId($this->_response['message_id'] ?? null);
            // BulkSMSBD doesn't return price in response
            $objResponseData->setMessagePrice(null);
        }

        return $objResponseData;
    }

    /**
     * Get account balance
     *
     * @return float
     */
    public function getBalance(): float
    {
        $response = Http::asMultipart()->post('http://bulksmsbd.net/api/getBalanceApi', [
            [
                'name' => 'api_key',
                'contents' => $this->apiKey,
            ],
        ]);

        $data = $response->json();

        if (($data['response_code'] ?? null) != 202) {
            throw new \Exception('BulkSMSBD balance check failed');
        }

        return (float) ($data['balance'] ?? 0);
    }
}