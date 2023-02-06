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

use Twig\Environment;
use Twig\Extension\RuntimeExtensionInterface;

interface RenderLinkRuntimeInterface extends RuntimeExtensionInterface
{
    public function renderLinkForCode(Environment $environment, string $code, array $options = [], ?string $template = null): string;

    public function getLinkForCode(string $code, array $options = []): string;
}
