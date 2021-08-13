<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\FrequentlyAskedQuestion\IndexPageInterface;
use Webmozart\Assert\Assert;

final class FrequentlyAskedQuestionContext implements Context
{
    /** @var IndexPageInterface */
    private $indexPage;

    public function __construct(IndexPageInterface $indexPage)
    {
        $this->indexPage = $indexPage;
    }

    /**
     * @When I go to the frequently asked questions list page
     */
    public function iGoToTheFrequentlyAskedQuestionsListPage(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :number FAQs ordered by position
     */
    public function iShouldSeeFaqsOrderedByPosition(int $number): void
    {
        Assert::true($this->indexPage->hasFrequentlyAskedQuestionsNumber($number));

        for ($i = 1; $i < $number; ++$i) {
            Assert::true($this->indexPage->hasQuestionWithPositionPrefixAtValidIndex($i));
        }
    }
}
