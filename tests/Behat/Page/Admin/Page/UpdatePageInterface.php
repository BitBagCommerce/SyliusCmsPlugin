<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ChecksCodeImmutabilityInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface, ChecksCodeImmutabilityInterface
{
    public const IMAGE_FORM_ID = 'bitbag_sylius_cms_plugin_page_translations_en_US_image';

    public function chooseImage(string $code): void;
}
