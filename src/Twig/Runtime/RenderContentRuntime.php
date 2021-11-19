<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
        $content = html_entity_decode((string) $contentableResource->getContent(), \ENT_QUOTES);

        return $this->contentParser->parse($content);
    }
}
