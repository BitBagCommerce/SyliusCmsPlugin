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

use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
class Page implements PageInterface
{
    use SectionableTrait;
    use ToggleableTrait;
    use ProductsAwareTrait;
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    /**
     * @var null|int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $code;

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->initializeProductsCollection();
        $this->initializeSectionsCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug(): ?string
    {
        return $this->getPageTranslation()->getSlug();
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug(?string $slug): void
    {
        $this->getPageTranslation()->setSlug($slug);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaKeywords(): ?string
    {
        return $this->getPageTranslation()->getMetaKeywords();
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaKeywords(?string $metaKeywords): void
    {
        $this->getPageTranslation()->setMetaKeywords($metaKeywords);
    }

    /**
     * {@inheritdoc}
     */
    public function getMetaDescription(): ?string
    {
        return $this->getPageTranslation()->getMetaDescription();
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaDescription(?string $metaDescription): void
    {
        $this->getPageTranslation()->setMetaDescription($metaDescription);
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): ?string
    {
        return $this->getPageTranslation()->getContent();
    }

    /**
     * {@inheritdoc}
     */
    public function setContent(?string $content): void
    {
        $this->getPageTranslation()->setContent($content);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->getPageTranslation()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): void
    {
        $this->getPageTranslation()->setName($name);
    }

    /**
     * @return PageTranslationInterface|TranslationInterface|null
     */
    protected function getPageTranslation(): PageTranslationInterface
    {
        return $this->getTranslation();
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation(): ?PageTranslationInterface
    {
        return new PageTranslation();
    }
}
