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

use BitBag\SyliusCmsPlugin\Entity\ContentableInterface;
use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParserInterface;

final class RenderContentExtension extends \Twig_Extension
{
    /** @var ContentParserInterface */
    private $contentParser;

    public function __construct(ContentParserInterface $contentParser)
    {
        $this->contentParser = $contentParser;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_Function('bitbag_cms_render_content', [$this, 'renderContent'], ['is_safe' => ['html']]),
        ];
    }

    public function renderContent(ContentableInterface $contentableResource): string
    {
        $content = (string) html_entity_decode((string) $contentableResource->getContent(), ENT_QUOTES);

        return $this->contentParser->parse($content);
    }
}
