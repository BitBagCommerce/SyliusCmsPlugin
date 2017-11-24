<?php

/**
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as BaseUpdatePage;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ChecksCodeImmutabilityTrait;
use Webmozart\Assert\Assert;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
    use ChecksCodeImmutabilityTrait;

    /**
     * {@inheritDoc}
     */
    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function uploadImage(string $image): void
    {
        $path = __DIR__ . '/../../../Resources/images/' . $image;

        Assert::fileExists($path);

        $this->getDocument()->attachFileToField('Choose file', $path);
    }

    /**
     * {@inheritdoc}
     */
    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    /**
     * {@inheritdoc}
     */
    public function fillLink(string $link): void
    {
        $this->getDocument()->fillField('Link', $link);
    }

    /**
     * {@inheritdoc}
     */
    public function fillContent(string $content): void
    {
        $this->getDocument()->fillField('Content', $content);
    }

    /**
     * {@inheritdoc}
     */
    public function disable(): void
    {
        $this->getDocument()->uncheckField('Enabled');
    }

    /**
     * {@inheritdoc}
     */
    public function isBlockDisabled(): bool
    {
        return $this->getDocument()->findField('Enabled')->isChecked();
    }
}
