<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Template;

interface CreatePageInterface
{
    public function fillField(string $field, string $value): void;

    public function fillName(string $name): void;

    public function chooseType(string $name): void;

    public function clickOnAddContentElementButton(): void;

    public function selectContentElement(string $contentElement): void;
}
