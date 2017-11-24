<?php

/**
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Page;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Behaviour\ContainsErrorInterface;

interface CreatePageInterface extends BaseCreatePageInterface, ContainsErrorInterface
{
    /**
     * @param string $field
     * @param string $value
     */
    public function fillField(string $field, string $value): void;

    /**
     * @param string $code
     */
    public function fillCode(string $code): void;

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
     * @param array $sectionsNames
     */
    public function associateSections(array $sectionsNames): void;
}
