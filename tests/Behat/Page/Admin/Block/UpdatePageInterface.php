<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Block;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ChecksCodeImmutabilityInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsContentElementInterface;

interface UpdatePageInterface extends
    BaseUpdatePageInterface,
    ChecksCodeImmutabilityInterface,
    ContainsContentElementInterface
{
    public function fillName(string $name): void;

    public function fillNameIfItIsEmpty(string $name): void;

    public function fillLink(string $link): void;

    public function fillContent(string $content): void;

    public function disable(): void;

    public function isBlockDisabled(): bool;

    public function changeTextareaContentElementValue(string $value): void;

    public function containsTextareaContentElementWithValue(string $value): bool;

    public function deleteContentElement(): void;
}
