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
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var RandomStringGeneratorInterface
     */
    private $randomStringGenerator;

    /**
     * @var FactoryInterface
     */
    private $sectionFactory;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param FactoryInterface $sectionFactory
     * @param SectionRepositoryInterface $sectionRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $sectionFactory,
        SectionRepositoryInterface $sectionRepository
    )
    {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->sectionFactory = $sectionFactory;
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @var SectionRepositoryInterface
     */
    private $sectionRepository;

    /**
     * @Given there is a section in the store
     */
    public function thereIsAnExistingSection(): void
    {
        $section = $this->createSection();

        $this->saveSection($section);
    }

    /**
     * @Given there are existing sections named :firstNameSection and :secondNameSection
     */
    public function thereAreExistingSections(string ...$sectionNames): void
    {
        foreach ($sectionNames as $sectionName) {
            $section = $this->createSection(null, $sectionName);

            $this->saveSection($section);
        }
    }

    /**
     * @Given there is an existing section with :code code
     */
    public function thereIsAnExistingSectionWithCode(string $code): void
    {
        $section = $this->createSection($code);

        $this->saveSection($section);
    }

    /**
     * @param string|null $code
     *
     * @return SectionInterface
     */
    private function createSection(?string $code = null, string $name = null): SectionInterface
    {
        /** @var SectionInterface $section */
        $section = $this->sectionFactory->createNew();

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        if (null === $name) {
            $name = $this->randomStringGenerator->generate();
        }

        $section->setCode($code);
        $section->setCurrentLocale('en_US');
        $section->setName($name);

        return $section;
    }

    /**
     * @param SectionInterface $section
     */
    private function saveSection(SectionInterface $section): void
    {
        $this->sectionRepository->add($section);
        $this->sharedStorage->set('section', $section);
    }
}
