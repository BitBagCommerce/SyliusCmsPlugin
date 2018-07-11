<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\WysiwygHelper;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ChecksCodeImmutabilityTrait;
use Webmozart\Assert\Assert;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ChecksCodeImmutabilityTrait;

    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    public function fillLink(string $link): void
    {
        $this->getDocument()->fillField('Link', $link);
    }

    public function fillContent(string $content): void
    {
        WysiwygHelper::fillContent($this->getSession(), $this->getDocument(), $content);
    }

    public function disable(): void
    {
        $this->getDocument()->uncheckField('Enabled');
    }

    public function isBlockDisabled(): bool
    {
        return $this->getDocument()->findField('Enabled')->isChecked();
    }
}
