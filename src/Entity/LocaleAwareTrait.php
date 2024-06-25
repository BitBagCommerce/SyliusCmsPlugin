<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/


declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Locale\Model\LocaleInterface;

trait LocaleAwareTrait
{
    protected Collection $locales;

    public function initializeLocalesCollection(): void
    {
        $this->locales = new ArrayCollection();
    }

    public function getLocales(): Collection
    {
        return $this->locales;
    }

    public function hasLocale(LocaleInterface $locale): bool
    {
        return $this->locales->contains($locale);
    }

    public function addLocale(LocaleInterface $locale): void
    {
        if (!$this->hasLocale($locale)) {
            $this->locales->add($locale);
        }
    }

    public function removeLocale(LocaleInterface $locale): void
    {
        if ($this->hasLocale($locale)) {
            $this->locales->removeElement($locale);
        }
    }
}
