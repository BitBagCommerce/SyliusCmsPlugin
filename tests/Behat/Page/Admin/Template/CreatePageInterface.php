<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Template;

interface CreatePageInterface
{
    public function fillField(string $field, string $value): void;

    public function fillName(string $name): void;

    public function chooseType(string $name): void;

    public function clickOnAddContentElementButton(): void;

    public function selectContentElement(string $contentElement): void;
}
