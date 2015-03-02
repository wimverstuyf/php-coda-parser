# php-coda-parser
PHP parser for Belgian CODA banking files

[![Build Status](https://secure.travis-ci.org/wimverstuyf/php-coda-parser.png?branch=master)](https://travis-ci.org/wimverstuyf/php-coda-parser)

## Installation

You can install Codelicious/Coda using Composer. You can read more about Composer and its main repository at
[http://packagist.org](http://packagist.org "Packagist"). First install Composer for your project using the instructions on the
Packagist home page, then define your dependency on Codelicious/Coda in your `composer.json` file.

```json
    {
        "require": {
            "codelicious/php-coda-parser": "dev-master"
        }
    }
```

## Usage

```php
<?php

use Codelicious\Coda\Parser;

$parser = new Parser();
$statements = $parser->parseFile('coda-file.cod', 'simple');

foreach ($statements as $statement) {
    echo $statement->date . "\n";

    foreach ($statement->transactions as $transaction) {
        echo $transaction->account->name . ": " . $transaction->amount . "\n";
    }

    echo $statement->new_balance . "\n";
}
```
    
## Statement structure

There are 2 structures available. 'raw' which resembles the original file structure and contains all information and 'simple' which is a simplified version only containing the most important information.
If you are unsure what to use you should use 'simple'.
Properties that are not supplied will be `null`.

*   `Codelicious\Coda\Simple\Statement`
    *   `date` Date of the supplied file (format YYYY-MM-DD)
    *   `account` Account for which the statements were created. An object implementing `Codelicious\Coda\Simple\Account`
    *   `original_balance` Balance of the account before the transactions were processed. Up to 3 decimals.
    *   `new_balance` Balance of the account after the transactions were processed. Up to 3 decimals.
    *   `free_messages` A list of text messages containing additional information
    *   `transaction` A list of transactions implemented as `Codelicious\Coda\Simple\Transaction`
*   `Codelicious\Coda\Simple\Account`
    *   `name` Name of the holder of the account
    *   `bic` Bankcode of the account
    *   `company_id` Official Belgian company number of the account holder
    *   `number` Banknumber of the account
    *   `currency` Currency of the account
    *   `country` Country of the account
*   `Codelicious\Coda\Simple\Transaction`
    *   `account` Account of the other party of the transaction. An object implementing `Codelicious\Coda\Simple\Account`
    *   `transaction_date` Date on which the transaction was requested
    *   `valuta_date` Date on which the transaction was executed by the bank
    *   `amount` Amount of the transaction. Up to 3 decimals. A negative number for credit transactions.
    *   `message` Message of the transaction
    *   `structured_message` Structured messages of the transaction (if available)
