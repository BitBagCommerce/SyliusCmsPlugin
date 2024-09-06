<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Resolver\Importer;

use Sylius\CmsPlugin\Entity\LocaleAwareInterface;

interface ImporterLocalesResolverInterface
{
    public function resolve(LocaleAwareInterface $localesAware, ?string $localesRow): void;
}
