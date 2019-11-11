# Nurkassa SDK for PHP v1

[![Latest Stable Version](http://img.shields.io/badge/Latest%20Stable-1.0.2-blue.svg)](https://packagist.org/packages/zmbakh/nurkassa-php-sdk)

## Installation

The Nurkassa PHP SDK can be installed with [Composer](https://getcomposer.org/). Run this command:

```sh
composer require zmbakh/nurkassa-php-sdk
```

Please be aware, that SDK only works with cURL or Guzzle 6.x out of the box.

## Usage

> **Note:** The SDK requires PHP 7.1 or greater.

Simple GET example of a list of the POSes.

```php
require_once __DIR__ . '/vendor/autoload.php'; // change path as needed

$nurkassa = new Nurkassa\Nurkassa();
$nurkassa->setAccessToken('h2rOjGoWhofLZHLO9K0xW3h8Pyfml7RG7ikLXSemHNhmaSgBrgDXNu5NMNs6'); //Example token.

$pos = new \Nurkassa\Models\ProgrammingMode\PosModel();
$request = $pos->index();

$response = $nurkassa->handleRequest($request);
```
The $response variable in the expample above contains headers, body and status code of the response.

The Models return a NurkassaRequest instance and were made to make easier request building. See [here](src/Models) to introduce with all the Models.
