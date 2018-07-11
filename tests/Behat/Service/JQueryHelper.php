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

use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;

final class JQueryHelper
{
    public static function waitForAsynchronousActionsToFinish(Session $session)
    {
        if ($session->getDriver() instanceof Selenium2Driver) {
            $session->wait(5000, '0 === jQuery.active');
        }
    }
}
