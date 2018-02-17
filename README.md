# Deprecated and not working
The repo which this package relied on is no longer working, sorry. Hopefully whatsapp will bring out their business API soon. If so I'll implement the new API in this laravel package.

# Laravel Whatsapp

This is a Laravel wrapper for the [whatsapp/chat-api](//github.com/mgp25/Chat-API) package

## Getting started
1. [Include the package in your application](#include-the-package-in-your-application)
2. [Register the service provider and aliases](#register-the-service-provider-and-aliases)
3. [Create a listener](#create-a-listener)
4. [Registration](#registration)
5. [Sending a message](#sending-a-message)

## Include the package in your application <a id="include-the-package-in-your-application"></a>

``` bash
composer require lucasvdh/laravelwhatsapp:dev-master
```
Or add a requirement to your project's composer.json

``` javascript
  "require": {
    "lucasvdh/laravelmacros": "dev-master"
  },
```

## Register the service provider and aliases <a id="register-the-service-provider-and-aliases"></a>

Edit the `config/app.php` file. Append the following to the `providers` array:

``` php
  'providers' => [
    // ...
    Lucasvdh\LaravelWhatsapp\WhatsappServiceProvider::class,
    // ...
  ],
```

Register the aliases:

``` php
  'aliases' => [
    // ...
    'Whatsapp' => Lucasvdh\LaravelWhatsapp\Facades\Whatsapp::class,
    // ...
  ],
```


## Create a listener <a id="create-a-listener"></a>

``` php
<?php namespace App\Listeners;

use Lucasvdh\LaravelWhatsapp\Abstracts\Listener as WhatsappListener

class WhatsappEventListener extends WhatsappListener
{
  // Check the Lucasvdh\LaravelWhatsapp\Interface\Listener for all events
}
```

## Registration <a id="registration"></a>

The registration flow.

### Request a code

``` php
$phone_number = '31612345678' // Your phone number including country code
$type = 'sms';
// $type = 'voice';
$result = Whatsapp::requestCode($phone_number, $type);
```

### Verify the registration code

``` php
$phone_number = '31612345678' // Your phone number including country code
$code = '123-456'; // The code you've received through sms or voice

try {
  $result = Whatsapp::register('$phone_number, $code);
}
catch(Exception $e) {
  die('Something went wrong during the registration: ' . $e->getMessage());
}

// Store this password, you'll need this to connect to the network
$password = $result['pw']
```

## Connecting to the network <a id="connecting-to-the-network"></a>

``` php
$phone_number = '31612345678' // Your phone number including country code
$display_name = 'Foo Bar'; // This is the name that other Whatsapp users will see
$password = '****************************'; // The password you received from the registration process 

// Fetch the connection
$connection = Whatsapp::getConnection($phone_number, $display_name);

// Initialize your listener
$listener = new WhatsappEventListener($connection);

// Connect to the network
$connection = Whatsapp::connect($connection, $password, $listener);

// You are now connected
```

## Sending a message <a id="sending-a-message"></a>

After connecting to the network you can send a message like this

``` php
$target = '3112345678'; // The phone number of the person you are sending the message to
$message = 'This is a message';

$message_hash = $connection->sendMessage($target , $message);
```

## Receiving messages <a id="receiving-messages"></a>

I recommend using Supervisor to run an artisan command in the background, but there are other ways 
to solve this. I've written an example for receiving messages with an artisan command using Supervisor.

### Setting up a background worker

### Configure Supervisor

### Events to listen for
