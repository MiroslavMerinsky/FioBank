# FioBank
FioBank API

It offers implementation of FioBank API described in the [documentation, ver.1.5.2](https://www.fio.cz/docs/cz/API_Bankovnictvi.pdf).

Installation
------------
```console
composer require merinsky/fiobank
```

Usage
-----
The **getBankStatement** method returns array of bank statements.
```php
define('API_KEY', '...');
$from = \DateTime::createFromFormat('Y-m-d', '2017-01-01');
$to = \DateTime::createFromFormat('Y-m-d', '2017-01-30');

// gets bank statements, period between $from and $to
$bank = new \Merinsky\FioBank\FioBank(API_KEY);
$bs = $bank->getBankStatement($from, $to);
```
