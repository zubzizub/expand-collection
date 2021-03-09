<?php

require __DIR__ . '/../vendor/autoload.php';

use App\CollectionCreator;

$expand = 'bonus.budget.currency,bonus.accrual_rules,bonus.budget,player.account,player.currency';

$collection = (new CollectionCreator($expand))->create();
var_dump($collection); exit;
