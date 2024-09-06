<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Parser;

interface ContentParserInterface
{
    public function parse(string $input): string;
}
