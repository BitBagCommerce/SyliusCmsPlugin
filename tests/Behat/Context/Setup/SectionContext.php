<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Repository\CollectionRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;

final class SectionContext implements Context
{
    public function __construct(
        private SharedStorageInterface         $sharedStorage,
        private RandomStringGeneratorInterface $randomStringGenerator,
        private FactoryInterface               $sectionFactory,
        private CollectionRepositoryInterface  $sectionRepository,
    ) {
    }

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
    public function thereAreExistingSections(string ...$sectionsNames): void
    {
        foreach ($sectionsNames as $sectionName) {
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
     * @Given there is a :sectionName section in the store
     */
    public function thereIsASectionInTheStore(string $sectionName): void
    {
        $section = $this->createSection(strtolower(StringInflector::nameToCode($sectionName)), $sectionName);

        $this->saveSection($section);
    }

    private function createSection(?string $code = null, string $name = null): CollectionInterface
    {
        /** @var CollectionInterface $section */
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

    private function saveSection(CollectionInterface $section): void
    {
        $this->sectionRepository->add($section);
        $this->sharedStorage->set('section', $section);
    }
}
