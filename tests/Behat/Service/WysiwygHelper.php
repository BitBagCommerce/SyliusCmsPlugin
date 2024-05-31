<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Service;

use DMore\ChromeDriver\ChromeDriver;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Session;
use Webmozart\Assert\Assert;

final class WysiwygHelper
{
    public static function fillContent(
        Session $session,
        DocumentElement $document,
        string $content,
        int $iframeNumber = 1,
    ): void {
        Assert::isInstanceOf($session->getDriver(), PantherDriver::class);

        $session->wait(3000);
        $session->switchToIFrame($iframeNumber);

        $document->find('css', '#bitbag-ckeditor')->setValue($content);

        $session->switchToIFrame(null);
    }
}
