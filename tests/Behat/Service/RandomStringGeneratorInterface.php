<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Service;

interface RandomStringGeneratorInterface
{
    public function generate(int $length = 10): string;
}
