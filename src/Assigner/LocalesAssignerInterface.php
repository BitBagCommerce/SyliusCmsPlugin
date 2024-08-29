<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\CmsPlugin\Entity\LocaleAwareInterface;

interface LocalesAssignerInterface
{
    public function assign(LocaleAwareInterface $localesAware, array $localesCodes): void;
}
