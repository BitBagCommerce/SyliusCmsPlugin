<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface UpdatePageInterface extends BaseUpdatePageInterface
{
    /**
     * @param string $name
     */
    public function fillName(string $name): void;

    /**
     * @param string $slug
     */
    public function fillSlug(string $slug): void;

    /**
     * @param string $metaKeywords
     */
    public function fillMetaKeywords(string $metaKeywords): void;

    /**
     * @param string $metaDescription
     */
    public function fillMetaDescription(string $metaDescription): void;

    /**
     * @param string $content
     */
    public function fillContent(string $content): void;

    /**
     * @param string $field
     * @param string $value
     */
    public function fillField(string $field, string $value): void;
}
