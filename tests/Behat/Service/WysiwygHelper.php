<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Service;

use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Session;
use DMore\ChromeDriver\ChromeDriver;
use Webmozart\Assert\Assert;

final class WysiwygHelper
{
    public static function fillContent(
        Session $session,
        DocumentElement $document,
        string $content,
        int $iframeNumber = 1,
    ): void {
        Assert::isInstanceOf($session->getDriver(), ChromeDriver::class);

        $session->wait(3000);
        $session->switchToIFrame($iframeNumber);

        $document->find('css', '#bitbag-ckeditor')->setValue($content);

        $session->switchToIFrame(null);
    }
}
