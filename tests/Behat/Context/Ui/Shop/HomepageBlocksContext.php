<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\Sylius\CmsPlugin\Behat\Page\Shop\HomePageInterface;
use Webmozart\Assert\Assert;

final class HomepageBlocksContext implements Context
{
    public function __construct(private HomePageInterface $blockHomePage)
    {
    }

    /**
     * @When I go to the homepage
     */
    public function iGoToTheHomepage(): void
    {
        $this->blockHomePage->open();
    }

    /**
     * @Then I want to see a text block with :content content
     */
    public function iWantToSeeATextBlockWithContent(string $content): void
    {
        Assert::true($this->blockHomePage->hasBlockWithContent($content));
    }
}
