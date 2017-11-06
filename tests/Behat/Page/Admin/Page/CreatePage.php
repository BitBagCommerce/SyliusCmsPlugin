<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Page\Admin\Page;

use Behat\Mink\Driver\Selenium2Driver;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Sylius\Behat\Service\SlugGenerationHelper;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\ContainsError;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    use ContainsError;

    /**
     * {@inheritDoc}
     */
    public function fillCode(string $code): void
    {
        $this->getDocument()->fillField('Code', $code);
    }

    /**
     * {@inheritDoc}
     */
    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);

        if ($this->getDriver() instanceof Selenium2Driver) {
            SlugGenerationHelper::waitForSlugGeneration($this->getSession(), $this->getElement('slug'));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function fillSlug(string $slug): void
    {
        $this->getDocument()->fillField('Slug', $slug);
    }

    /**
     * {@inheritDoc}
     */
    public function fillMetaKeywords(string $metaKeywords): void
    {
        $this->getDocument()->fillField('Meta keywords', $metaKeywords);
    }

    /**
     * {@inheritDoc}
     */
    public function fillMetaDescription(string $metaDescription): void
    {
        $this->getDocument()->fillField('Meta description', $metaDescription);
    }

    /**
     * {@inheritDoc}
     */
    public function fillContent(string $content): void
    {
        $this->getDocument()->fillField('Content', $content);
    }

    /**
     * {@inheritDoc}
     */
    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    /**
     * @return array
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'slug' => '#bitbag_plugin_page_translations_en_US_slug',
        ]);
    }
}