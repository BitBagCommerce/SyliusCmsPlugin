<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Behat\Mink\Element\DocumentElement;
use Behat\MinkExtension\Context\RawMinkContext;

final class TrixWysiwygContext extends RawMinkContext implements Context
{
    /**
     * @Then I should see the Trix WYSIWYG editor initialized
     */
    public function iShouldSeeTheTrixWysiwygEditorInitialized(): void
    {
        $this->getPage()->find('css', 'trix-toolbar')->setValue('test');
    }

    private function getPage(): DocumentElement
    {
        return $this->getSession()->getPage();
    }
}
