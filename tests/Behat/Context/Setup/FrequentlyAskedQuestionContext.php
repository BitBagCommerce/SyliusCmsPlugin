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
    private $frequentlyAskedQuestionFactory;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param RandomStringGeneratorInterface $randomStringGenerator
     * @param FactoryInterface $frequentlyAskedQuestionFactory
     * @param FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        RandomStringGeneratorInterface $randomStringGenerator,
        FactoryInterface $frequentlyAskedQuestionFactory,
        FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository
    )
    {
        $this->sharedStorage = $sharedStorage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->frequentlyAskedQuestionFactory = $frequentlyAskedQuestionFactory;
        $this->frequentlyAskedQuestionRepository = $frequentlyAskedQuestionRepository;
    }

    /**
     * @var FrequentlyAskedQuestionRepositoryInterface
     */
    private $frequentlyAskedQuestionRepository;

    /**
     * @Given the store has a frequently asked question
     */
    public function thereIsAnExistingFrequentlyAskedQuestion(): void
    {
        $frequentlyAskedQuestion = $this->createFrequentlyAskedQuestion();

        $this->saveFrequentlyAskedQuestion($frequentlyAskedQuestion);
    }

    /**
     * @Given there is an existing frequently asked question with :position position
     */
    public function thereIsAnExistingFrequentlyAskedQuestionWithPosition(int $position): void
    {
        $frequentlyAskedQuestion = $this->createFrequentlyAskedQuestion(null, $position);

        $this->saveFrequentlyAskedQuestion($frequentlyAskedQuestion);
    }

    /**
     * @Given there is an existing frequently asked question with :code code
     */
    public function thereIsAnExistingFrequentlyAskedQuestionWithCode(string $code): void
    {
        $frequentlyAskedQuestion = $this->createFrequentlyAskedQuestion($code);

        $this->saveFrequentlyAskedQuestion($frequentlyAskedQuestion);
    }

    /**
     * @param null|string $code
     * @param int|null $position
     *
     * @return FrequentlyAskedQuestionInterface
     */
    private function createFrequentlyAskedQuestion(?string $code = null, int $position = null): FrequentlyAskedQuestionInterface
    {
        /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
        $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        if (null === $position) {
            $position = 1;
        }

        $frequentlyAskedQuestion->setCode($code);
        $frequentlyAskedQuestion->setPosition($position);
        $frequentlyAskedQuestion->setCurrentLocale('en_US');
        $frequentlyAskedQuestion->setQuestion($this->randomStringGenerator->generate());
        $frequentlyAskedQuestion->setAnswer($this->randomStringGenerator->generate());

        return $frequentlyAskedQuestion;
    }

    /**
     * @param FrequentlyAskedQuestionInterface $frequentlyAskedQuestion
     */
    private function saveFrequentlyAskedQuestion(FrequentlyAskedQuestionInterface $frequentlyAskedQuestion): void
    {
        $this->frequentlyAskedQuestionRepository->add($frequentlyAskedQuestion);
        $this->sharedStorage->set('frequently_asked_question', $frequentlyAskedQuestion);
    }
}
