<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Entity\SectionableInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Webmozart\Assert\Assert;

final class SectionsAssigner implements SectionsAssignerInterface
{
    /** @var SectionRepositoryInterface */
    private $sectionRepository;

    public function __construct(SectionRepositoryInterface $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function assign(SectionableInterface $sectionsAware, array $sectionsCodes): void
    {
        foreach ($sectionsCodes as $sectionCode) {
            /** @var SectionInterface $section */
            $section = $this->sectionRepository->findOneBy(['code' => $sectionCode]);

            Assert::notNull($section, sprintf('Section with %s code not found.', $sectionCode));
            $sectionsAware->addSection($section);
        }
    }
}
