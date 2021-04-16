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

use BitBag\SyliusCmsPlugin\Entity\ContentableInterface;
use BitBag\SyliusCmsPlugin\Twig\Parser\ContentParserInterface;

final class RenderContentRuntime implements RenderContentRuntimeInterface
{
    /** @var ContentParserInterface */
    private $contentParser;

    public function __construct(ContentParserInterface $contentParser)
    {
        $this->contentParser = $contentParser;
    }

    public function renderContent(ContentableInterface $contentableResource): string
    {
        $content = (string) html_entity_decode((string) $contentableResource->getContent(), \ENT_QUOTES);

        return $this->contentParser->parse($content);
    }
}
