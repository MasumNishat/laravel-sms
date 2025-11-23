# Laravel SMS Gateway

[![Latest Stable Version](https://poser.pugx.org/masum/sms-gateway/v/stable)](https://packagist.org/packages/masum/sms-gateway)
[![Total Downloads](https://poser.pugx.org/masum/sms-gateway/downloads)](https://packagist.org/packages/masum/sms-gateway)
[![Latest Unstable Version](https://poser.pugx.org/masum/sms-gateway/v/unstable)](https://packagist.org/packages/masum/sms-gateway)
[![License](https://poser.pugx.org/masum/sms-gateway/license)](https://packagist.org/packages/masum/sms-gateway)

A Laravel package that provides a unified interface to send SMS through various providers. It supports multiple SMS gateways and is easily extendable to support new gateways.

## Features

- **Multiple Provider Support**: Twilio, Nexmo/Vonage, MessageBird, Dialog, BulkSMS Bangladesh, SSL Wireless
- **Simple API**: Unified interface across all providers
- **Easy Configuration**: Configure via `.env` file
- **Extendable**: Easy to add new SMS providers
- **Laravel Integration**: Seamless integration with Laravel applications

## Supported Gateways

### International Providers
- **Twilio** - Global SMS provider (Trial & Production)
- **Nexmo/Vonage** - Global SMS provider
- **MessageBird** - Global SMS provider
- **Dialog** - Sri Lanka SMS provider

### Bangladesh Providers
- **BulkSMS Bangladesh** - Cost-effective local provider
- **SSL Wireless** - Local enterprise provider

## Installation

Install the package via Composer:

```bash
composer require masum/sms-gateway
```

### Publish Configuration

Publish the configuration file to your Laravel application:

```bash
php artisan vendor:publish --provider="Masum\SmsGateway\SmsServiceProvider"
```

This will create a `config/sms_gateway.php` file in your application.

## Configuration

### Environment Variables

Add your SMS provider credentials to your `.env` file:

```bash
# Twilio Configuration
TWILIO_SID="your_account_sid"
TWILIO_TOKEN="your_auth_token"
TWILIO_SMS_FROM="+15005550006"

# Nexmo/Vonage Configuration
NEXMO_API_KEY="your_api_key"
NEXMO_API_SECRET="your_api_secret"
NEXMO_SMS_FROM="YourBrand"

# MessageBird Configuration
MESSAGE_BIRD_API_KEY="your_api_key"
MESSAGE_BIRD_SMS_FROM="+12012926824"

# Dialog (Sri Lanka) Configuration
DIALOG_SMS_API_KEY="your_api_key"
DIALOG_SMS_ENDPOINT="your_endpoint"
DIALOG_SMS_FROM="YourBrand"

# BulkSMS Bangladesh Configuration
BULKSMSBD_API_KEY="your_api_key"
BULKSMSBD_SENDER_ID="8809601000000"

# SSL Wireless Configuration
SSL_WIRELESS_USER="your_username"
SSL_WIRELESS_PASS="your_password"
SSL_WIRELESS_SID="your_sender_id"
```

### Configuration File

The published `config/sms_gateway.php` file contains settings for all supported providers:

```php
return [
    'nexmo_sms_api_settings' => [
        'API_KEY' => env('NEXMO_API_KEY', ''),
        'API_SECRET' => env('NEXMO_API_SECRET', ''),
        'SEND_SMS_FROM' => env('NEXMO_SMS_FROM', 'YourBrand'),
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
        'SEND_SMS_FROM' => env('DIALOG_SMS_FROM', 'YourBrand'),
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
```

## Usage

### Basic Usage

```php
use Masum\SmsGateway\SmsGateway;
use Masum\SmsGateway\TwilioSmsGateway;

// Create gateway instance
$gateway = new TwilioSmsGateway();
$sms = new SmsGateway($gateway);

// Send SMS
$sms->sendSms('+1234567890', 'Hello from Laravel!');

// Get response data
$response = $sms->getResponseData();
echo "Status: " . $response->getStatus();
echo "Message ID: " . $response->getMessageId();
```

### Dynamic Provider Selection

```php
use Masum\SmsGateway\SmsGateway;

$provider = config('app.sms_provider', 'twilio');

$gateway = match ($provider) {
    'bulksmsbd' => new \Masum\SmsGateway\BulkSmsBdGateway(),
    'ssl_wireless' => new \Masum\SmsGateway\SslWirelessSmsGateway(),
    'nexmo' => new \Masum\SmsGateway\NexmoSmsGateway(),
    'message_bird' => new \Masum\SmsGateway\MessageBirdSmsGateway(),
    'dialog' => new \Masum\SmsGateway\DialogSmsGateway(),
    default => new \Masum\SmsGateway\TwilioSmsGateway(),
};

$sms = new SmsGateway($gateway);
$sms->sendSms($phoneNumber, $message);
```

## Provider Specific Documentation

---

### Twilio

<a href="https://www.twilio.com/" target="_blank">
<img src="https://www.twilio.com/marketing/bundles/company/img/logos/red/twilio-logo-red.svg" height="70" alt="Twilio">
</a>

Twilio is a cloud communications platform that allows developers to programmatically make and receive phone calls, send and receive text messages, and perform other communication functions.

**Website**: [twilio.com](https://www.twilio.com/)

**Documentation**: [Twilio API Docs](https://www.twilio.com/docs/api)

**Trial Credit**: $15.50 free credit for testing

#### Configuration

Add your Twilio credentials to `.env`:

```bash
TWILIO_SID="your_account_sid"
TWILIO_TOKEN="your_auth_token"
TWILIO_SMS_FROM="+15005550006"
```

#### Usage Example

```php
use Masum\SmsGateway\SmsGateway;
use Masum\SmsGateway\TwilioSmsGateway;

$sms = new SmsGateway(new TwilioSmsGateway());
$sms->sendSms('+1234567890', 'Hello from Twilio!');
```

#### Testing with Magic Numbers

For trial accounts, use Twilio's magic test numbers:
- **FROM**: `+15005550006`
- **TO**: `+15005550000`, `+15005550001`, etc.

---

### Nexmo/Vonage

<a href="https://www.nexmo.com/" target="_blank">
<img src="https://www.nexmo.com/wp-content/uploads/2015/06/nexmo-logo-lg.jpg" height="70" alt="Nexmo">
</a>

Nexmo (now Vonage) provides innovative communication SMS and Voice APIs that enable applications and enterprises to easily connect to their customers.

**Website**: [nexmo.com](https://www.nexmo.com/)

**Documentation**: [developer.nexmo.com](https://developer.nexmo.com/)

**Trial Credit**: 2 EUR free test credit

#### Configuration

Add your Nexmo credentials to `.env`:

```bash
NEXMO_API_KEY="your_api_key"
NEXMO_API_SECRET="your_api_secret"
NEXMO_SMS_FROM="YourBrand"
```

#### Usage Example

```php
use Masum\SmsGateway\SmsGateway;
use Masum\SmsGateway\NexmoSmsGateway;

$sms = new SmsGateway(new NexmoSmsGateway());
$sms->sendSms('+1234567890', 'Hello from Nexmo!');
```

---

### MessageBird

<a href="https://www.messagebird.com/en/" target="_blank">
<img src="https://www.messagebird.com/img/logo.svg" height="70" alt="MessageBird">
</a>

MessageBird provides powerful communication APIs and technical resources to help you build your communication solution.

**Website**: [messagebird.com](https://www.messagebird.com/en/)

**Documentation**: [developers.messagebird.com](https://developers.messagebird.com/)

**Trial Credit**: 10 free SMS credits

#### Configuration

Add your MessageBird credentials to `.env`:

```bash
MESSAGE_BIRD_API_KEY="your_api_key"
MESSAGE_BIRD_SMS_FROM="+12012926824"
```

#### Usage Example

```php
use Masum\SmsGateway\SmsGateway;
use Masum\SmsGateway\MessageBirdSmsGateway;

$sms = new SmsGateway(new MessageBirdSmsGateway());
$sms->sendSms('+1234567890', 'Hello from MessageBird!');
```

---

### Dialog (Sri Lanka)

<a href="https://www.dialog.lk/" target="_blank">
<img src="https://www.dialog.lk/dialogdocroot/content/images/dialog_logo@2x.png" height="70" alt="Dialog">
</a>

Dialog Axiata PLC provides a Bulk SMS Solution that enables you to communicate via SMS to a mass list of customers/staff through an easy-to-use web portal.

**Website**: [dialog.lk](https://www.dialog.lk/)

#### Configuration

Add your Dialog credentials to `.env`:

```bash
DIALOG_SMS_API_KEY="your_api_key"
DIALOG_SMS_ENDPOINT="your_endpoint"
DIALOG_SMS_FROM="YourBrand"
```

#### Usage Example

```php
use Masum\SmsGateway\SmsGateway;
use Masum\SmsGateway\DialogSmsGateway;

$sms = new SmsGateway(new DialogSmsGateway());
$sms->sendSms('+94771234567', 'Hello from Dialog!');
```

---

### BulkSMS Bangladesh

BulkSMS Bangladesh is a cost-effective local SMS provider for Bangladesh. It automatically handles Bangladesh phone number formatting.

**Phone Number Formats**: Accepts `+8801712345678`, `8801712345678`, or `01712345678`

#### Configuration

Add your BulkSMS BD credentials to `.env`:

```bash
BULKSMSBD_API_KEY="your_api_key"
BULKSMSBD_SENDER_ID="8809601000000"
```

#### Usage Example

```php
use Masum\SmsGateway\SmsGateway;
use Masum\SmsGateway\BulkSmsBdGateway;

$sms = new SmsGateway(new BulkSmsBdGateway());
$sms->sendSms('+8801712345678', 'Hello from BulkSMS BD!');
```

---

### SSL Wireless

SSL Wireless is a local enterprise SMS provider for Bangladesh.

**Phone Number Format**: Requires full international format (`+8801XXXXXXXXX`)

#### Configuration

Add your SSL Wireless credentials to `.env`:

```bash
SSL_WIRELESS_USER="your_username"
SSL_WIRELESS_PASS="your_password"
SSL_WIRELESS_SID="your_sender_id"
```

#### Usage Example

```php
use Masum\SmsGateway\SmsGateway;
use Masum\SmsGateway\SslWirelessSmsGateway;

$sms = new SmsGateway(new SslWirelessSmsGateway());
$sms->sendSms('+8801712345678', 'Hello from SSL Wireless!');
```

---

## Response Handling

All gateways return a `ResponseData` object with the following methods:

```php
$response = $sms->getResponseData();

// Get response status
$status = $response->getStatus();

// Get unique message ID
$messageId = $response->getMessageId();

// Get message price (if available)
$price = $response->getMessagePrice();
```

## Error Handling

Always wrap SMS sending in try-catch blocks for proper error handling:

```php
use Masum\SmsGateway\SmsGateway;
use Masum\SmsGateway\TwilioSmsGateway;

try {
    $sms = new SmsGateway(new TwilioSmsGateway());
    $sms->sendSms('+1234567890', 'Hello World!');

    $response = $sms->getResponseData();
    echo "SMS sent! Message ID: " . $response->getMessageId();
} catch (\Exception $e) {
    // Log the error
    \Log::error("SMS sending failed: " . $e->getMessage());

    // Handle the error gracefully
    echo "Failed to send SMS. Please try again.";
}
```

## Extending the Package

To add support for a new SMS provider:

1. Create a new gateway class implementing `SmsGatewayInterface`:

```php
namespace Masum\SmsGateway;

class CustomSmsGateway implements SmsGatewayInterface
{
    public function send($to, $message)
    {
        // Implementation
    }

    public function getResponseData(): ResponseData
    {
        // Implementation
    }
}
```

2. Add configuration to `config/sms_gateway.php`:

```php
'custom_sms_api_settings' => [
    'API_KEY' => env('CUSTOM_SMS_API_KEY', ''),
    // Other settings
],
```

3. Use your new gateway:

```php
$sms = new SmsGateway(new CustomSmsGateway());
$sms->sendSms('+1234567890', 'Hello!');
```

## Available Gateway Classes

- `TwilioSmsGateway` - Twilio SMS gateway
- `NexmoSmsGateway` - Nexmo/Vonage SMS gateway
- `MessageBirdSmsGateway` - MessageBird SMS gateway
- `DialogSmsGateway` - Dialog (Sri Lanka) SMS gateway
- `BulkSmsBdGateway` - BulkSMS Bangladesh gateway
- `SslWirelessSmsGateway` - SSL Wireless Bangladesh gateway

All classes implement the `SmsGatewayInterface`.

## Requirements

- PHP >= 8.1
- Laravel >= 10.x
- Illuminate HTTP Client (for API requests)

## Testing

Test your SMS integration using Laravel Tinker:

```bash
php artisan tinker
```

```php
$sms = new \Masum\SmsGateway\SmsGateway(new \Masum\SmsGateway\TwilioSmsGateway());
$sms->sendSms('+1234567890', 'Test message');
$response = $sms->getResponseData();
var_dump($response);
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/new-gateway`)
3. Commit your changes (`git commit -am 'Add new SMS gateway'`)
4. Push to the branch (`git push origin feature/new-gateway`)
5. Create a new Pull Request

You can also contribute by:
- Reporting bugs via [Issues](https://github.com/MasumNishat/laravel-sms/issues)
- Suggesting improvements
- Writing tests
- Improving documentation

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## Support

For issues, questions, or feature requests:
- **Email**: masum.nishat21@gmail.com
- **Issues**: [GitHub Issues](https://github.com/MasumNishat/laravel-sms/issues)

## Credits

- **Author**: Masum Nishat
- **Email**: masum.nishat21@gmail.com
- **GitHub**: [MasumNishat](https://github.com/MasumNishat)

## Changelog

### Version 1.0.0
- Initial release with Twilio, Nexmo, MessageBird, and Dialog support

### Version 2.0.0 (Latest)
- Added BulkSMS Bangladesh gateway
- Added SSL Wireless Bangladesh gateway
- Improved phone number formatting for Bangladesh providers
- Updated configuration structure
- Enhanced error handling
- Updated documentation