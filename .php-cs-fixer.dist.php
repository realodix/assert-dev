<?php

use Realodix\CsConfig\Config;
use Realodix\CsConfig\Finder;
use Realodix\CsConfig\Rules\Realodix;

$overrides = [
    'binary_operator_spaces' => ['operators' => ['=>' => 'align_single_space_minimal']],
];

$finder = Finder::base(__DIR__)
    ->append(['.php-cs-fixer.dist.php']);

return Config::create(new Realodix($overrides))
    ->setFinder($finder);
