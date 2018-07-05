<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Assigner\SectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionableInterface;

final class ImporterSectionsResolver implements ImporterSectionsResolverInterface
{
    /** @var SectionsAssignerInterface */
    private $sectionsAssigner;

    public function __construct(SectionsAssignerInterface $sectionsAssigner)
    {
        $this->sectionsAssigner = $sectionsAssigner;
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
