<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Template;

interface UpdatePageInterface
{
    public function hasContentElement(string $contentElement): bool;

    public function hasOnlyContentElement(string $contentElement): bool;

    public function fillName(string $name): void;

    public function deleteContentElement(string $name): void;
}
