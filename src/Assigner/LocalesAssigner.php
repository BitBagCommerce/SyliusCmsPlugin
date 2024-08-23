<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Entity\LocaleAwareInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

final class LocalesAssigner implements LocalesAssignerInterface
{
    public function __construct(private RepositoryInterface $localeRepository)
    {
    }

    public function assign(LocaleAwareInterface $localesAware, array $localesCodes): void
    {
        $locales = $this->localeRepository->findBy(['code' => $localesCodes]);
        Assert::allIsInstanceOf($locales, LocaleInterface::class);

        foreach ($locales as $locale) {
            $localesAware->addLocale($locale);
        }
    }
}
