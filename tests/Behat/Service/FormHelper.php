<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Service;

use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\Mink\Session;

final class FormHelper
{
    public static function fillHiddenInput(Session $session, string $id, $value): void
    {
        try {
            $session->executeScript(
                sprintf(
                    "document.getElementById('%s').value = '%s';",
                    $id,
                    $value
                )
            );
        }
            /** @noinspection PhpRedundantCatchClauseInspection */
        catch (UnsupportedDriverActionException $ex) {
            $session->getPage()
                ->find('css','input#'.$id)
                ->setValue($value)
            ;
        }
    }
}
