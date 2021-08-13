<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    public const IMAGE_FORM_ID = 'bitbag_sylius_cms_plugin_page_translations_en_US_image';

    public function fillField(string $field, string $value): void;

    public function chooseImage(string $code): void;

    public function fillCode(string $code): void;

    public function fillName(string $name): void;

    public function fillSlug(string $slug): void;

    public function fillMetaKeywords(string $metaKeywords): void;

    public function fillMetaDescription(string $metaDescription): void;

    public function fillContent(string $content): void;

    public function associateSections(array $sectionsNames): void;
}
