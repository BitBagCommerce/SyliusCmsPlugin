<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Service;

use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\Mink\Session;

final class FormHelper
{
    public static function fillHiddenInput(
        Session $session,
        string $id,
        $value,
    ): void {
        try {
            $session->executeScript(
                sprintf(
                    "document.getElementById('%s').value = '%s';",
                    $id,
                    $value,
                ),
            );
        }
        /** @noinspection PhpRedundantCatchClauseInspection */
        catch (UnsupportedDriverActionException $ex) {
            $session->getPage()
                ->find('css', 'input#' . $id)
                ->setValue($value)
            ;
        }
    }
}
