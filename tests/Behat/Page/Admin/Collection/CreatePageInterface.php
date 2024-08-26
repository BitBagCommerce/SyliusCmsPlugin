<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Page\Admin\Collection;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\Sylius\CmsPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    public function fillField(string $field, string $value): void;

    public function fillCode(string $code): void;

    public function fillName(string $name): void;
}
