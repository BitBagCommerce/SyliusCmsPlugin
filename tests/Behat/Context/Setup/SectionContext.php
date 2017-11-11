<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\CmsPlugin\Entity\SectionInterface;
use BitBag\CmsPlugin\Repository\SectionRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class SectionContext implements Context
{
    /**
     * @var RandomStringGeneratorInterface
     */
    private $randomStringGenerator;

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var FactoryInterface
     */
    private $sectionFactory;

    /**
     * @var SectionRepositoryInterface
     */
    private $sectionRepository;

    /**
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param SharedStorageInterface $sharedStorage
     * @param FactoryInterface $sectionFactory
     * @param SectionRepositoryInterface $sectionRepository
     */
    public function __construct(
        RandomStringGeneratorInterface $randomStringGenerator,
        SharedStorageInterface $sharedStorage,
        FactoryInterface $sectionFactory,
        SectionRepositoryInterface $sectionRepository
    )
    {
        $this->randomStringGenerator = $randomStringGenerator;
        $this->sharedStorage = $sharedStorage;
        $this->sectionFactory = $sectionFactory;
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @Given there is a section in the store
     */
    public function thereIsAnExistingSection(): void
    {
        /** @var SectionInterface $section */
        $section = $this->sectionFactory->createNew();

        $section->setCode($this->randomStringGenerator->generate());

        $this->sharedStorage->set('section', $section);
        $this->sectionRepository->add($section);
    }

    /**
     * @Given there are existing sections named :firstNameSection and :secondNameSection
     */
    public function thereAreExistingSections(string ...$sectionNames): void
    {
        foreach ($sectionNames as $sectionName) {
            $section = $this->createSection();

            $section->setCurrentLocale('en_US');
            $section->setName($sectionName);

            $this->sectionRepository->add($section);
        }
    }

    /**
     * @Given there is an existing section with :code code
     */
    public function thereIsAnExistingSectionWithCode(string $code): void
    {
        $section = $this->createSection();

        $section->setCode($code);

        $this->sectionRepository->add($section);
    }

    /**
     * @return SectionInterface
     */
    private function createSection(): SectionInterface
    {
        /** @var SectionInterface $section */
        $section = $this->sectionFactory->createNew();

        $section->setCode($this->randomStringGenerator->generate());

        return $section;
    }
}
