<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Entity\SectionableInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Webmozart\Assert\Assert;

final class SectionsAssigner implements SectionsAssignerInterface
{
    public function __construct(private SectionRepositoryInterface $sectionRepository)
    {
    }

    public function assign(SectionableInterface $sectionsAware, array $sectionsCodes): void
    {
        foreach ($sectionsCodes as $sectionCode) {
            /** @var SectionInterface|null $section */
            $section = $this->sectionRepository->findOneBy(['code' => $sectionCode]);

            Assert::notNull($section, sprintf('Section with %s code not found.', $sectionCode));
            $sectionsAware->addSection($section);
        }
    }
}
