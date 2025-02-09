<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Form\Type\Wysiwyg\WysiwygStrategyInterface;

interface WysiwygStrategyResolverInterface
{
    public function getStrategy(string $wysiwygType): WysiwygStrategyInterface;
}
