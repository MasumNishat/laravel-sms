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
 * SslWirelessSmsGateway The class to send sms using SSL Wireless Bangladesh API
 *
 * @category SslWirelessSmsGateway
 * @package  Masum_SmsGateway
 * @author   Masum Nishat <masum.nishat21@gmail.com>
 * @link     https://github.com/MasumNishat/laravel-sms
 */
class SslWirelessSmsGateway implements SmsGatewayInterface
{
    protected $user;

    protected $pass;

    protected $sid;

    private $_response;

    /**
     * The class constructor
     */
    public function __construct()
    {
        $this->user = config('sms_gateway.ssl_wireless_sms_api_settings.USER');
        $this->pass = config('sms_gateway.ssl_wireless_sms_api_settings.PASS');
        $this->sid = config('sms_gateway.ssl_wireless_sms_api_settings.SID');
    }

    /**
     * The function to send sms using SSL Wireless Bangladesh API
     *
     * @param String $smsTo   The recipient number
     * @param String $message The sms message
     *
     * @return mixed The response from API
     */
    public function send($smsTo, $message)
    {
        $params = [
            'user' => $this->user,
            'pass' => $this->pass,
            'sid' => $this->sid,
            'sms' => [
                [
                    'msisdn' => $smsTo,
                    'msg' => $message,
                    'cs' => 'utf-8',
                ],
            ],
        ];

        $response = Http::post('https://smsplus.sslwireless.com/api/v3/send-sms', $params);

        $this->_response = $response->json();

        if (!$response->successful() || !isset($this->_response['data'])) {
            throw new \Exception('SSL Wireless API error: ' . $response->body());
        }

        return $this->_response;
    }

    /**
     * The function to get response from SSL Wireless Bangladesh API
     *
     * @return ResponseData
     */
    public function getResponseData(): ResponseData
    {
        $objResponseData = new ResponseData();
        if (isset($this->_response['data']) && is_array($this->_response['data']) && count($this->_response['data']) > 0) {
            $firstMessage = $this->_response['data'][0];
            $objResponseData->setStatus($firstMessage['status'] ?? 'unknown');
            $objResponseData->setMessageId($firstMessage['message_id'] ?? null);
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
        $response = Http::post('https://smsplus.sslwireless.com/api/v3/balance', [
            'user' => $this->user,
            'pass' => $this->pass,
        ]);

        $data = $response->json();

        return (float) ($data['data']['balance'] ?? 0);
    }
}