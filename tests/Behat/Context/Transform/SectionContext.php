<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Webmozart\Assert\Assert;

final class SectionContext implements Context
{
    /** @var SectionRepositoryInterface */
    private $sectionRepository;

    /** @var string */
    private $locale;

    public function __construct(SectionRepositoryInterface $sectionRepository, string $locale = 'en_US')
    {
        $this->sectionRepository = $sectionRepository;
        $this->locale = $locale;
    }

    /**
     * @Transform /^section(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" section(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :section
     */
    public function getSectionByCode(string $sectionCode): SectionInterface
    {
        $section = $this->sectionRepository->findOneByCode($sectionCode, $this->locale);

        Assert::notNull(
            $section,
            sprintf('No sections has been found with code "%s".', $sectionCode),
        );

        return $section;
    }
}
