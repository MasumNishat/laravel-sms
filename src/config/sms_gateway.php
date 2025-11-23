<?php
/**
 * The Sms Gateway Configuration - The configuration file for the SMS Gateway.
 *
 * PHP version 7.1
 *
 * @category PHP/Laravel
 * @package  Masum_SmsGateway
 * @author   Masum Nishat <masum.nishat21@gmail.com>
 * @link     https://github.com/MasumNishat/laravel-sms
 */

return [
    'nexmo_sms_api_settings' => [
        'API_KEY' => env('NEXMO_API_KEY', ''),
        'API_SECRET' => env('NEXMO_API_SECRET', ''),
        'SEND_SMS_FROM' => env('NEXMO_SMS_FROM', 'Masum'),
    ],
    'twilio_sms_api_settings' => [
        'SID' => env('TWILIO_SID', ''),
        'TOKEN' => env('TWILIO_TOKEN', ''),
        'SEND_SMS_FROM' => env('TWILIO_SMS_FROM', '+15005550006'),
    ],
    'message_bird_sms_api_settings' => [
        'API_KEY' => env('MESSAGE_BIRD_API_KEY', ''),
        'SEND_SMS_FROM' => env('MESSAGE_BIRD_SMS_FROM', '+12012926824'),
    ],
    'dialog_sms_api_settings' => [
        'API_KEY' => env('DIALOG_SMS_API_KEY', ''),
        'ENDPOINT' => env('DIALOG_SMS_ENDPOINT', ''),
        'SEND_SMS_FROM' => env('DIALOG_SMS_FROM', 'Masum'),
    ],
    'bulksmsbd_sms_api_settings' => [
        'API_KEY' => env('BULKSMSBD_API_KEY', ''),
        'SENDER_ID' => env('BULKSMSBD_SENDER_ID', '8809601000000'),
    ],
    'ssl_wireless_sms_api_settings' => [
        'USER' => env('SSL_WIRELESS_USER', ''),
        'PASS' => env('SSL_WIRELESS_PASS', ''),
        'SID' => env('SSL_WIRELESS_SID', ''),
    ],
];
