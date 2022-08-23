<?php

use Realodix\Relax\Config;

$localRules = [
    'binary_operator_spaces' => ['operators' => ['=>' => 'align_single_space_minimal']],
];

return Config::create('@Realodix', $localRules);
