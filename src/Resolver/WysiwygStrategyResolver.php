<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Form\Type\Wysiwyg\WysiwygStrategyInterface;

class WysiwygStrategyResolver implements WysiwygStrategyResolverInterface
{
    public function __construct(
        private array $strategies,
        private string $default,
    ) {
    }

    public function getStrategy(string $wysiwygType): WysiwygStrategyInterface
    {
        return $this->strategies[$wysiwygType] ?? $this->strategies[$this->default];
    }
}
