<?php

/**
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use BitBag\SyliusCmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;

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
     * @Given there are :number FAQs in the store
     */
    public function thereAreFaqsInTheStore(int $number): void
    {
        for ($i = 1; $i <= $number; $i++) {
            $frequentlyAskedQuestion = $this->createFrequentlyAskedQuestion(null, $i, true);

            $this->saveFrequentlyAskedQuestion($frequentlyAskedQuestion);
        }
    }

    /**
     * @param null|string $code
     * @param int|null $position
     * @param bool $prefixQuestionWithPosition
     *
     * @return FrequentlyAskedQuestionInterface
     */
    private function createFrequentlyAskedQuestion(
        ?string $code = null,
        int $position = null,
        bool $prefixQuestionWithPosition = false
    ): FrequentlyAskedQuestionInterface
    {
        /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
        $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();

        if (null === $code) {
            $code = $this->randomStringGenerator->generate();
        }

        if (null === $position) {
            $position = 1;
        }

        $question = $this->randomStringGenerator->generate();

        if (true === $prefixQuestionWithPosition) {
            $question = $position . '. ' . $question;
        }

        $frequentlyAskedQuestion->setCode($code);
        $frequentlyAskedQuestion->setPosition($position);
        $frequentlyAskedQuestion->setCurrentLocale('en_US');
        $frequentlyAskedQuestion->setQuestion($question);
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
