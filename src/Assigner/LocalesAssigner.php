<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Assigner;

use Sylius\CmsPlugin\Entity\LocaleAwareInterface;
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
