<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\CmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use BitBag\CmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class FrequentlyAskedQuestionContext implements Context
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
    private $frequentlyAskedQuestionFactory;

    /**
     * @var FrequentlyAskedQuestionRepositoryInterface
     */
    private $frequentlyAskedQuestionRepository;

    /**
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param SharedStorageInterface $sharedStorage
     * @param FactoryInterface $frequentlyAskedQuestionFactory
     * @param FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository
     */
    public function __construct(
        RandomStringGeneratorInterface $randomStringGenerator,
        SharedStorageInterface $sharedStorage,
        FactoryInterface $frequentlyAskedQuestionFactory,
        FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository
    )
    {
        $this->randomStringGenerator = $randomStringGenerator;
        $this->sharedStorage = $sharedStorage;
        $this->frequentlyAskedQuestionFactory = $frequentlyAskedQuestionFactory;
        $this->frequentlyAskedQuestionRepository = $frequentlyAskedQuestionRepository;
    }

    /**
     * @Given the store has a frequently asked question
     */
    public function thereIsAnExistingFrequentlyAskedQuestion(): void
    {
        /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
        $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();
        
        $frequentlyAskedQuestion->setCode($this->randomStringGenerator->generate());
        $frequentlyAskedQuestion->setPosition(1);

        $this->sharedStorage->set('frequently_asked_question', $frequentlyAskedQuestion);
        $this->frequentlyAskedQuestionRepository->add($frequentlyAskedQuestion);
    }

    /**
     * @Given there is an existing frequently asked question with :position position
     */
    public function thereIsAnExistingFrequentlyAskedQuestionWithPosition(int $position): void
    {
        /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
        $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();

        $frequentlyAskedQuestion->setCode($this->randomStringGenerator->generate());
        $frequentlyAskedQuestion->setPosition($position);

        $this->frequentlyAskedQuestionRepository->add($frequentlyAskedQuestion);
    }

    /**
     * @Given there is an existing frequently asked question with :code code
     */
    public function thereIsAnExistingFrequentlyAskedQuestionWithCode(string $code): void
    {
        /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
        $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();

        $frequentlyAskedQuestion->setCode($code);
        $frequentlyAskedQuestion->setPosition(1);

        $this->frequentlyAskedQuestionRepository->add($frequentlyAskedQuestion);
    }
}
