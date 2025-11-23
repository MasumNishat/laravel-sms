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

use Illuminate\Support\ServiceProvider;
use Config;

/**
 * SmsServiceProvider The service provider for SMS service
 *
 * @category SmsServiceProvider
 * @package  Masum_SmsGateway
 * @author   Masum Nishat <masum.nishat21@gmail.com>
 * @link     https://github.com/MasumNishat/laravel-sms
 */
class SmsServiceProvider extends ServiceProvider
{
    /**
     * The boot function
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__.'/config/sms_gateway.php' => config_path('sms_gateway.php'),
            ],
            'sms-gateway-config'
        );
    }



    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SmsGatewayInterface::class, NexmoSmsGateway::class);
    }
}
