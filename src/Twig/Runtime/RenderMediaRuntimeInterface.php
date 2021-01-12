<?php
/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.io and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

interface RenderMediaRuntimeInterface extends RuntimeExtensionInterface
{
    public function renderMedia(string $code): string;
}
