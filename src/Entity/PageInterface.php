<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
interface PageInterface extends
    ResourceInterface,
    TranslatableInterface,
    ToggleableInterface,
    ProductableInterface,
    SectionableInterface
{
    /**
     * @return null|string
     */
    public function getSlug(): ?string;

    /**
     * @param null|string $slug
     */
    public function setSlug(?string $slug): void;

    /**
     * @return null|string
     */
    public function getCode(): ?string;

    /**
     * @param null|string $code
     */
    public function setCode(?string $code): void;

    /**
     * @return null|string
     */
    public function getMetaKeywords(): ?string;

    /**
     * @param null|string $metaKeywords
     */
    public function setMetaKeywords(?string $metaKeywords): void;

    /**
     * @return null|string
     */
    public function getMetaDescription(): ?string;

    /**
     * @param null|string $metaDescription
     */
    public function setMetaDescription(?string $metaDescription): void;

    /**
     * @return null|string
     */
    public function getContent(): ?string;

    /**
     * @param string $content |string
     */
    public function setContent(?string $content): void;

    /**
     * @return null|string
     */
    public function getName(): ?string;

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void;
}
