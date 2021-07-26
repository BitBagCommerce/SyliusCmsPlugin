<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Webmozart\Assert\Assert;

final class FrequentlyAskedQuestionContext implements Context
{
    private $apiClient;

    private $responseChecker;

    public function __construct(
        ApiClientInterface $apiClient,
        ResponseCheckerInterface $responseChecker
    ) {
        $this->apiClient = $apiClient;
        $this->responseChecker = $responseChecker;
    }

    /**
     * @Given /^I want to browse FAQs$/
     */
    public function iWantToBrowseFAQs(): void
    {
        $this->apiClient->index();
    }

    /**
     * @Then /^I should see (\d+) question(?:s)? in the list$/
     */
    public function iShouldSeeQuestionsInTheList(string $count): void
    {
        Assert::count($this->responseChecker->getCollection(
            $this->apiClient->getLastResponse()),
            $count
        );
    }

    /**
     * @Given /^I should see the "([^"]*)" question$/
     */
    public function iShouldSeeTheQuestion(string $code): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithValue(
                $this->apiClient->index(),
                "code",
                $code
            ),
            sprintf('There is no question with code "%s"', $code)
        );
    }

    /**
     * @When I view faq with code :faq
     */
    public function iViewFaqWithCode(FrequentlyAskedQuestionInterface $faq): void
    {
        $this->apiClient->show((string)$faq->getId());
    }

    /**
     * @Then I should see question with random text
     */
    public function iShouldSeeQuestionWithRandomText(): void
    {
        Assert::false(
            $this->responseChecker->hasTranslation(
                $this->apiClient->getLastResponse(),
                "en_US",
                "question",
                "That shouldn't exist"
            ), "Missing question"
        );
    }

    /**
     * @Given /^I should see answer with random text$/
     */
    public function iShouldSeeAnswerWithRandomText(): void
    {
        Assert::false(
            $this->responseChecker->hasTranslation(
                $this->apiClient->getLastResponse(),
                "en_US",
                "answer",
                "That shouldn't exist"
            ), "Missing answer"
        );
    }
}
