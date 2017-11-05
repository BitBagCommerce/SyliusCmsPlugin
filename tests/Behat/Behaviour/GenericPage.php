<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Behaviour;

use Behat\Mink\Driver\Selenium2Driver;
use Sylius\Behat\Behaviour\DocumentAccessor;
use Sylius\Behat\Service\SlugGenerationHelper;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
trait GenericPage
{
    use DocumentAccessor;

    /**
     * @param string $name
     */
    public function fillName(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);

        if ($this->getDriver() instanceof Selenium2Driver) {
            SlugGenerationHelper::waitForSlugGeneration($this->getSession(), $this->getElement('slug'));
        }
    }

    /**
     * @param string $slug
     */
    public function fillSlug(string $slug): void
    {
        $this->getDocument()->fillField('Slug', $slug);
    }

    /**
     * @param string $metaKeywords
     */
    public function fillMetaKeywords(string $metaKeywords): void
    {
        $this->getDocument()->fillField('Meta keywords', $metaKeywords);
    }

    /**
     * @param string $metaDescription
     */
    public function fillMetaDescription(string $metaDescription): void
    {
        $this->getDocument()->fillField('Meta description', $metaDescription);
    }

    /**
     * @param string $content
     */
    public function fillContent(string $content): void
    {
        $this->getDocument()->fillField('Content', $content);
    }

    /**
     * @param string $field
     * @param string $value
     */
    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField( $field, $value);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'slug' => '#bitbag_plugin_page_translations_en_US_slug',
        ]);
    }
}