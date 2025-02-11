<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Form\Strategy\Wysiwyg\WysiwygStrategyInterface;

interface WysiwygStrategyResolverInterface
{
    public function getStrategy(string $wysiwygType): WysiwygStrategyInterface;
}
