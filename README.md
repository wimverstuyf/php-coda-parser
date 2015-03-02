# php-coda-parser
PHP parser for Belgian CODA banking files


## Installation

Coming soon...
You can install Codelicious/Coda using Composer. You can read more about Composer and its main repository at
[http://packagist.org](http://packagist.org "Packagist"). First install Composer for your project using the instructions on the
Packagist home page, then define your dependency on Codelicious/Coda in your `composer.json` file.

```json
    {
        "require": {
            "codelicious/coda": ">=0.1"
        }
    }
```

## Usage

```php
<?php

use Codelicious\Coda\Parser;

$parser = new Parser();
$statements = $parser->parseFile('coda-file.cod');

foreach ($statements as $statement) {
    echo $statement->identification->creation_date . "\n";

    foreach ($statement->transactions as $transaction) {
        echo $transaction->amount . "\n";
    }

    echo $statement->new_situation->balance . "\n";
}
```

## Statement structure

The returned statements have the following properties.
Properties that are not supplied will be `null`.

*   `Codelicious\Coda\Statement`
    *   `getNumber()` Statement sequence number
    *   `getAccount()` An object implementing `Jejik\MT940\AccountInterface`
    *   `getOpeningBalance()` An object implementing `Jejik\MT940\BalanceInterface`
    *   `getClosingBalance()` An object implementing `Jejik\MT940\BalanceInterface`
    *   `getTransactions()` An array of objects implementing `Jejik\MT940\TransactionInterface`
*   `Codelicious\Coda\AccountInterface`
    *   `getNumber()` The account number
    *   `getName()` The account holder name
*   `Codelicious\Coda\BalanceInterface`
    *   `getCurrency()` 3-letter ISO 4217 currency code
    *   `getAmount()` Balance amount
    *   `getDate()` Balance date as a `\DateTime` object
*   `Codelicious\Coda\TransactionInterface`
    *   `getContraAccount()` An object implementing `Jejik\MT940\AccountInterface`
    *   `getAmount()` Transaction amount
    *   `getDescription()` Description text
    *   `getValueDate()` Date of the transaction as a `\DateTime`
    *   `getBookDate()` Date the transaction was booked as a `\DateTime`
