<?php

use Realodix\Relax\Config;

$localRules = [
    'binary_operator_spaces' => ['operators' => ['=>' => 'align_single_space_minimal']],
    'native_function_invocation' => true
];

return Config::create('@Realodix', $localRules);
