# omnipay-payway

This is a plugin for [omnipay/omnipay](https://github.com/omnipay/omnipay) for
the Westpac PayWay system. View their readme for more information.

It is currently incomplete (unit tests need writing, and only supports
`purchase()`, but “works for me”.

## Example usage

```
<?php

include 'vendor/autoload.php';

use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

$gateway = Omnipay::create('Payway');

$gateway->setUsername('REPLACE');
$gateway->setPassword('REPLACE');
$gateway->setMerchant('REPLACE');
$gateway->setCertificate('/PATH/TO/FILE/ccapi.pem');

$card = new CreditCard(array(
    'number' => '4564710000000004',
    'cvv' => '847',
    'expiryMonth' => '02',
    'expiryYear' => '19',
    'firstName' => 'Dion',
    'lastName' => 'Moult'
));

$request = $gateway->purchase(array(
    'transactionId' => '01',
    'amount' => '1.00',
    'card' => $card,
    'currency' => 'AUD'
));

$response = $request->send();

var_dump($response->isSuccessful());
var_dump($response->isRedirect());
var_dump($response->getTransactionReference());
var_dump($response->getMessage());
var_dump($response->getResponseCode());
```
