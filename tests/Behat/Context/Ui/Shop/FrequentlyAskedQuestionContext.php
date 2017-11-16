<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\FrequentlyAskedQuestion\IndexPageInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class FrequentlyAskedQuestionContext implements Context
{
    /**
     * @var IndexPageInterface
     */
    private $indexPage;

    /**
     * @param IndexPageInterface $indexPage
     */
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

        for ($i = 1; $i < $number; $i++) {
            Assert::true($this->indexPage->hasQuestionWithPositionPrefixAtValidIndex($i));
        }
    }
}
