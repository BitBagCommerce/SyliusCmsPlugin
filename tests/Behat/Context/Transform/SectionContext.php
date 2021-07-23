<?php

/*
 *  This file has been created by developers from BitBag.
 *  Feel free to contact us once you face any issues or want to start
 *  another great project.
 *  You can find more information about us on https://bitbag.shop and write us
 *  an email on mikolaj.krol@bitbag.pl.
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
        $this->locale            = $locale;
    }

    /**
     * @Transform /^section(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" section(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :section
     */
    public function getSectionByCode($sectionCode): SectionInterface
    {
        $section = $this->sectionRepository->findOneByCode($sectionCode, $this->locale);

        Assert::notNull(
            $section,
            sprintf('No sections has been found with code "%s".', $sectionCode)
        );

        return $section;
    }
}
