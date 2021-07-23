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
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use BitBag\SyliusCmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Webmozart\Assert\Assert;

final class FrequentlyAskedQuestionContext implements Context
{
    /** @var FrequentlyAskedQuestionRepositoryInterface */
    private $frequentlyAskedQuestionRepository;

    public function __construct(
        FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository
    ) {
        $this->frequentlyAskedQuestionRepository = $frequentlyAskedQuestionRepository;
    }

    /**
     * @Transform /^faq(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" faq(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :faq
     */
    public function getFAQByCode($faqCode): FrequentlyAskedQuestionInterface
    {
        $faq = $this->frequentlyAskedQuestionRepository->findOneEnabledByCode($faqCode);

        Assert::notNull(
            $faq,
            sprintf('No FAQs has been found with code "%s".', $faqCode)
        );

        return $faq;
    }
}
