<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver\Importer;

use BitBag\SyliusCmsPlugin\Assigner\LocalesAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\LocaleAwareInterface;

final class ImporterLocalesResolver implements ImporterLocalesResolverInterface
{
    public function __construct(private LocalesAssignerInterface $localesAssigner)
    {
    }

    public function resolve(LocaleAwareInterface $localesAware, ?string $localesRow): void
    {
        if (empty($localesRow)) {
            return;
        }

        $channelsCodes = explode(',', $localesRow);
        $channelsCodes = array_map(static function (string $element): string {
            return trim($element);
        }, $channelsCodes);

        $this->localesAssigner->assign($localesAware, $channelsCodes);
    }
}
