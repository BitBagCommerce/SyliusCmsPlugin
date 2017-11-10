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
use Doctrine\ORM\EntityManagerInterface;
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
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * SectionContext constructor.
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param SharedStorageInterface $sharedStorage
     * @param FactoryInterface $sectionFactory
     * @param SectionRepositoryInterface $sectionRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        RandomStringGeneratorInterface $randomStringGenerator,
        SharedStorageInterface $sharedStorage,
        FactoryInterface $sectionFactory,
        SectionRepositoryInterface $sectionRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->randomStringGenerator = $randomStringGenerator;
        $this->sharedStorage = $sharedStorage;
        $this->sectionFactory = $sectionFactory;
        $this->sectionRepository = $sectionRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Given there is are existing sections named :firstNameSection and :secondNameSection
     */
    public function thereIsAnExistingFaqWithPosition(string $firstNameSection, string $secondNameSection): void
    {
        /** @var SectionInterface $firstSection */
        $firstSection = $this->createSection();
        /** @var SectionInterface $secondSection */
        $secondSection = $this->createSection();

        $firstSection->setName($firstNameSection);

        $secondSection->setName($secondNameSection);

        $this->entityManager->flush();
    }

    /**
     * @return SectionInterface
     */
    private function createSection(): SectionInterface
    {
        /** @var SectionInterface $section */
        $section = $this->sectionFactory->createNew();
        $channel = $this->sharedStorage->get('channel');

        $section->setCurrentLocale($channel->getLocales()->first()->getCode());
        $section->setCode($this->randomStringGenerator->generate());
        $section->setName($this->randomStringGenerator->generate());

        $this->sectionRepository->add($section);

        return $section;
    }
}
