<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Fixture\Factory;

interface FixtureFactoryInterface
{
    public function load(array $data): void;
}
