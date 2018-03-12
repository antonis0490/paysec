# Paysec: Paysec

**Paysec driver for the Paysec PHP payment processing library**

## Installation

Paysec is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "Paysec/paysec": "dev-master"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

To make a request:

    use Omnipay\Omnipay;
    use Omnipay\Paysec\Message\StatusCallback;

    $gateway = Omnipay::create('Paysec');

    $gateway->initialize(array(
        'clientId' => "your client id",
        'secret' => "your secret,
        'testMode' =>  // Or false when you are ready for live transactions
    ));
    
    $options = array
    (

        "header" => "3",
        "clientId" => "",
        "channelCode" => "BANK_TRANSFER",
        "notifyURL" => "",
        "returnURL" => "",
        "amount" => "",
        "orderTime" => (string)round(microtime(true) * 1000),
        "cartId" => "",
        "currency" => "",
        "email" => "",
        "name" => "",
        "lname" => ""

    );
    
    $transaction = $gateway->purchase($options);
    $response = $transaction->send();
    $resData = $response->getData();
    
    
Notify function:

    $status = new StatusCallback($_REQUEST);

    $secret = "";
    $wallet = "";
    $validSignature = "";
    
    if ($validSignature && $status->isSuccessful()) {
        //sucess
    } else if ($validSignature && $status->isPending()) {
        //pending
    } else if ($validSignature) {
        //failed
    } else {
        //error
    }
The following gateways are provided by this package:

* Paysec

For general usage instructions, please see the main [Omnipay](https://omnipay.thephpleague.com/)
site.
