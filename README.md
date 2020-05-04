# Perfect Money Payment API Integration

[![Total Issues](https://img.shields.io/github/issues/MunnaAhmed/perfectmoney)]
[![Total Fork](https://img.shields.io/github/forks/MunnaAhmed/perfectmoney)]
[![Total Stars](https://img.shields.io/github/stars/MunnaAhmed/perfectmoney)]

> A Laravel Package for Perfect Money Payment API Integration

## Installation

[PHP](https://php.net) 5.4+ or [HHVM](http://hhvm.com) 3.3+, and [Composer](https://getcomposer.org) are required.

You should be enable perfemoney api mode from account settings on your account.

To get the latest version, simply require it

```bash
composer require munna/pm
```

Or add the following line to the require block of your `composer.json` file.

```
"munna/pm": "1.0.*"
```


Current Version

```bash
    "1.0.1"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.


Once Munna\Pm is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `Munna\Pm\PerfectMoneyServiceProvider::class`

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Munna\Pm\PerfectMoneyServiceProvider"
```

A configuration-file named `perfectmoney.php` with some sensible defaults will be placed in your `config` directory:

```php
<?php

return [

    /**
     * Perfect Money Login Account ID
     *
     */
    'perfect_money_account' => '12345678',

    /**
     * Perfect Money Loggin Password 
     *
     */
    'perfect_money_password' => 'YOUR_PASSWORD',

    /**
     * Perfect Money Payer Account ID [Like U123456]
     *
     */
    'perfect_money_payeraccount' => 'Your_Account_id',

];
```

Let me explain the fluent methods this package provides a bit here.
```php

/**
 *  Create an instance of PerfectMoney
 */

$pm = new PerfectMoney;

/**
 *  Check Your Account
 */
$pm->getName();


/**
 *  Check Your Balance
 *  Normally you can see all your balances
 */
$pm->balance();


/**
 *  To check specify current balance you need to pass an one optional parameter
 *  Support ["USD", "EURO", "Troy oz."] etc
 */
$pm->balance("USD");


/**
 *  Sent or Transfer Amount To Others Account
 *  All send parameter are required
 *  $receiver = "Payee Account ID [LIKE: U123456]"
 *  $amount = 100 [Int, double Value]
 *  $payment_id = "Random Payment Id" to track your transaction
 *  $memo = "Description About Your Send or Transfer"
 */
$pm->send($receiver, $amount, $payment_id, $memo);

```

## License

The MIT License (MIT).
