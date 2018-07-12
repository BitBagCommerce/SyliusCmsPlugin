<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Exception;

final class ImportFailedException extends \RuntimeException
{
    public function __construct(string $message, int $index)
    {
        parent::__construct(sprintf('Import failed at index %d. Exception message: %s', $index, $message));
    }
}
