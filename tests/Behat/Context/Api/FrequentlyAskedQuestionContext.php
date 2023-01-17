<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Api;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Resources;
use Webmozart\Assert\Assert;

final class FrequentlyAskedQuestionContext implements Context
{
    private ApiClientInterface $apiClient;

    private ResponseCheckerInterface $responseChecker;

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
        $this->apiClient->index(Resources::FAQ);
    }

    /**
     * @Then /^I should see (\d+) question(?:s)? in the list$/
     */
    public function iShouldSeeQuestionsInTheList(string $count): void
    {
        Assert::count(
            $this->responseChecker->getCollection(
                $this->apiClient->getLastResponse()
            ),
            (int) $count
        );
    }

    /**
     * @Given /^I should see the "([^"]*)" question$/
     */
    public function iShouldSeeTheQuestion(string $code): void
    {
        Assert::true(
            $this->responseChecker->hasItemWithValue(
                $this->apiClient->index(Resources::FAQ),
                'code',
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
        $this->apiClient->show(Resources::FAQ, (string) $faq->getId());
    }

    /**
     * @Then I should see question with random text
     */
    public function iShouldSeeQuestionWithRandomText(): void
    {
        Assert::false(
            $this->responseChecker->hasTranslation(
                $this->apiClient->getLastResponse(),
                'en_US',
                'question',
                "That shouldn't exist"
            ),
            'Missing question'
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
                'en_US',
                'answer',
                "That shouldn't exist"
            ),
            'Missing answer'
        );
    }
}
