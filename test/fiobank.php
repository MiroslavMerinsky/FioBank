<?php

include_once '../src/FioBank/FioBank.php';
include_once 'config.php';

$bank = new \Merinsky\FioBank\FioBank(API_KEY);
$bs = $bank->getBankStatement(new \DateTime('2017-01-01'), new \DateTime());

print_r($bs);
