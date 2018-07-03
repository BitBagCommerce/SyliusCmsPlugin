<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Entity\CompilableContentInterface;

final class RenderContentExtension extends \Twig_Extension
{
    public function getFunctions(): array
    {
        return [
            new \Twig_Function('bitbag_cms_render_content', [$this, 'renderContent'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    public function renderContent(
        \Twig_Environment $twigEnvironment,
        CompilableContentInterface $compilableContent
    ): string
    {
        if (true === $compilableContent->getCompilable()) {
            $content = html_entity_decode($compilableContent->getContent(), ENT_QUOTES);

            try {
                return $twigEnvironment->createTemplate($content)->render([]);
            } catch (\Exception $exception) {
                return $compilableContent->getContent();
            }
        }

        return $compilableContent->getContent();
    }
}
