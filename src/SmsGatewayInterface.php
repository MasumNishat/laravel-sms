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

/**
 * SmsGatewayInterface The abstract class for SMSGateway
 *
 * @category SmsGatewayInterface
 * @package  Masum_SmsGateway
 * @author   Masum Nishat <masum.nishat21@gmail.com>
 * @link     https://github.com/MasumNishat/laravel-sms
 */
interface SmsGatewayInterface
{

    /**
     * The abstract function to send sms using provided  SMS API
     *
     * @param String $message The sms message
     * @param String $smsTo      The recipient number
     *
     * @return mixed The response from API
     */
    public function send($message, $smsTo);

    /**
     * The abstract function to get response from the API
     *
     * @return ResponseData The response object
     */
    public function getResponseData():ResponseData;
}
