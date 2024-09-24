<?php

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Media;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    public function fillField(string $field, string $value): void;

    public function uploadFile(string $file): void;

    public function fillCode(string $code): void;

    public function fillName(string $name): void;

    public function fillContent(string $content): void;

    public function associateCollections(array $collectionsNames): void;
}
