<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Template;

interface UpdatePageInterface
{
    public function hasContentElement(string $contentElement): bool;

    public function hasOnlyContentElement(string $contentElement): bool;

    public function fillName(string $name): void;

    public function deleteContentElement(string $name): void;
}
