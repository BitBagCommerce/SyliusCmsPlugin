<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;

final class SectionContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var RandomStringGeneratorInterface */
    private $randomStringGenerator;

    /** @var FactoryInterface */
    private $sectionFactory;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $sectionFactory,
        SectionRepositoryInterface $sectionRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->sectionFactory = $sectionFactory;
        $this->sectionRepository = $sectionRepository;
    }

    /** @var SectionRepositoryInterface */
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

    private function createSection(?string $code = null, string $name = null, ChannelInterface $channel = null): SectionInterface
    {
        /** @var SectionInterface $section */
        $section = $this->sectionFactory->createNew();

        if (null === $channel && $this->sharedStorage->has('channel')) {
            $channel = $this->sharedStorage->get('channel');
        }

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        if (null === $name) {
            $name = $this->randomStringGenerator->generate();
        }

        $section->setCode($code);
        $section->setCurrentLocale('en_US');
        $section->setName($name);
        $section->addChannel($channel);

        return $section;
    }

    private function saveSection(SectionInterface $section): void
    {
        $this->sectionRepository->add($section);
        $this->sharedStorage->set('section', $section);
    }
}
