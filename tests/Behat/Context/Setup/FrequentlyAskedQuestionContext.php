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
use BitBag\CmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use BitBag\CmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

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
     * @var FactoryInterface
     */
    private $frequentlyAskedQuestionFactory;

    /**
     * @var FrequentlyAskedQuestionRepositoryInterface
     */
    private $askedQuestionRepository;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param FactoryInterface $frequentlyAskedQuestionFactory
     * @param FrequentlyAskedQuestionRepositoryInterface $askedQuestionRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        FactoryInterface $frequentlyAskedQuestionFactory,
        FrequentlyAskedQuestionRepositoryInterface $askedQuestionRepository
    )
    {
        $this->sharedStorage = $sharedStorage;
        $this->frequentlyAskedQuestionFactory = $frequentlyAskedQuestionFactory;
        $this->askedQuestionRepository = $askedQuestionRepository;
    }

    /**
     * @Given there is an existing faq with :position position
     */
    public function thereIsAnExistingFaqWithPosition(int $position): void
    {
        /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
        $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();
        $frequentlyAskedQuestion->setPosition($position);

        $this->askedQuestionRepository->add($frequentlyAskedQuestion);
    }
}
