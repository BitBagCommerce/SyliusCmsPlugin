<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ECSConfig $config): void {
    $config->import('vendor/bitbag/coding-standard/ecs.php');

    $parameters = $config->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);
};
