<?php

use Realodix\Relax\Config;
use Realodix\Relax\RuleSet\Sets\Realodix;

$localRules = [
    'binary_operator_spaces' => ['operators' => ['=>' => 'align_single_space_minimal']],
    'native_function_invocation' => true
];

return Config::create(new Realodix, $localRules);
