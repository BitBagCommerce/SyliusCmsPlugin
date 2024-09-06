<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Locale\Model\LocaleInterface;

interface LocaleAwareInterface
{
    public function initializeLocalesCollection(): void;

    public function getLocales(): Collection;

    public function hasLocale(LocaleInterface $locale): bool;

    public function addLocale(LocaleInterface $locale): void;

    public function removeLocale(LocaleInterface $locale): void;
}
