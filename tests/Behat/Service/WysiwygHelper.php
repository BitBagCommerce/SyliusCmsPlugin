<?php

/*
 * This file has been created by developers from BitBag. 
 * Feel free to contact us once you face any issues or want to start
 * another great project. 
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl. 
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Service;

use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Session;
use DMore\ChromeDriver\ChromeDriver;
use Webmozart\Assert\Assert;

final class WysiwygHelper
{
    public static function fillContent(Session $session, DocumentElement $document, string $content, int $iframeNumber = 1): void
    {
        Assert::isInstanceOf($session->getDriver(), ChromeDriver::class);

        $session->wait(3000);
        $session->switchToIFrame($iframeNumber);

        $document->find('css', '#bitbag-ckeditor')->setValue($content);

        $session->switchToIFrame(null);
    }
}
