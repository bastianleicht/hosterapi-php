HosterAPI PHP API Client
=======================
This **PHP 7.2+** library allows you to communicate with Venocix HosterAPI.

[![Latest Stable Version](http://poser.pugx.org/bastianleicht/hosterapi-php/v)](https://packagist.org/packages/bastianleicht/hosterapi-php)
[![Total Downloads](http://poser.pugx.org/bastianleicht/hosterapi-php/downloads)](https://packagist.org/packages/bastianleicht/hosterapi-php)
[![Latest Unstable Version](http://poser.pugx.org/bastianleicht/hosterapi-php/v/unstable)](https://packagist.org/packages/bastianleicht/hosterapi-php)
[![License](http://poser.pugx.org/bastianleicht/hosterapi-php/license)](https://packagist.org/packages/bastianleicht/hosterapi-php)

> You can find the full API documentation [here](https://reseller.hosterapi.de/api)!

## Getting Started

Recommended installation is using **Composer**!

In the root of your project execute the following:
```sh
$ composer require bastianleicht/hosterapi-php
```

Or add this to your `composer.json` file:
```json
{
    "require": {
        "bastianleicht/hosterapi-php": "^1.0"
    }
}
```

Then perform the installation:
```sh
$ composer install --no-dev
```

### Examples

Creating the HosterAPI main object:
```php
<?php
// Require the autoloader
require_once 'vendor/autoload.php';

// Use the library namespace
use Venocix\HosterAPI\HosterAPI;

// Then simply pass your API-Token when creating the API client object.
$client = new HosterAPI('API-Token');

// Then you are able to perform a request
var_dump($client->virtualServer()->list());
?>
```

If you want more info on how to use this PHP-API you should check out the [Wiki](https://github.com/bastianleicht/hosterapi-php/wiki).