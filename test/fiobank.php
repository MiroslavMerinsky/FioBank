<?php

include_once '../src/FioBank/FioBank.php';
include_once 'config.php';

$bank = new \Merinsky\FioBank\FioBank(API_KEY);
$bs = $bank->getBankStatement(\DateTime::createFromFormat('Y-m-d', '2017-01-01'), new \DateTime());

print_r($bs);
