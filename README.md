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
            "codelicious/php-coda-parser": "^2.0"
        }
    }
```

Or you can execute the following command in your project root to install this library:

```sh
composer require codelicious/php-coda-parser:^2.0
```

## Demo / API

You can try the parser at [https://eenvoudigfactureren.be/coda](https://eenvoudigfactureren.be/coda). 
An open API is also available at the same page if you don't feel like hosting the code yourself.


## Usage

```php
<?php

use Codelicious\Coda\Parser;

$parser = new Parser();
$statements = $parser->parseFile('coda-file.cod');

foreach ($statements as $statement) {
    echo $statement->getDate()->format('Y-m-d') . "\n";

    foreach ($statement->getTransactions() as $transaction) {
        echo $transaction->getAccount()->getName() . ": " . $transaction->getAmount() . "\n";
    }

    echo $statement->getNewBalance() . "\n";
}
```
