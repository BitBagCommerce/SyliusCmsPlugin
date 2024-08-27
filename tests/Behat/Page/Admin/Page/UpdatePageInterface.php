<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ChecksCodeImmutabilityInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsContentElementInterface;

interface UpdatePageInterface extends
    BaseUpdatePageInterface,
    ChecksCodeImmutabilityInterface,
    ContainsContentElementInterface
{
    public const IMAGE_FORM_ID = 'sylius_cms_plugin_page_translations_en_US_image';

    public function chooseImage(string $code): void;

    public function changeTextareaContentElementValue(string $value): void;

    public function containsTextareaContentElementWithValue(string $value): bool;

    public function deleteContentElement(): void;
}
