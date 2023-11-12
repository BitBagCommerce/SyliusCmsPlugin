<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Assigner\SectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionableInterface;

final class ImporterSectionsResolver implements ImporterSectionsResolverInterface
{
    public function __construct(private SectionsAssignerInterface $sectionsAssigner)
    {
    }

    public function resolve(SectionableInterface $sectionable, ?string $sectionsRow): void
    {
        if (null === $sectionsRow) {
            return;
        }

        $sectionCodes = explode(',', $sectionsRow);
        $sectionCodes = array_map(function (string $element): string {
            return trim($element);
        }, $sectionCodes);

        $this->sectionsAssigner->assign($sectionable, $sectionCodes);
    }
}
