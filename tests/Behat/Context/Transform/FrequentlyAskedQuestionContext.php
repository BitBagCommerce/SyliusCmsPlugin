<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
        FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository,
    ) {
        $this->frequentlyAskedQuestionRepository = $frequentlyAskedQuestionRepository;
    }

    /**
     * @Transform /^faq(?:|s) "([^"]+)"$/
     * @Transform /^"([^"]+)" faq(?:|s)$/
     * @Transform /^(?:a|an) "([^"]+)"$/
     * @Transform :faq
     */
    public function getFAQByCode(string $faqCode): FrequentlyAskedQuestionInterface
    {
        $faq = $this->frequentlyAskedQuestionRepository->findOneEnabledByCode($faqCode);

        Assert::notNull(
            $faq,
            sprintf('No FAQs has been found with code "%s".', $faqCode),
        );

        return $faq;
    }
}
