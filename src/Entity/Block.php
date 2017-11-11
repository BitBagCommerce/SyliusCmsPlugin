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

use Sylius\Component\Core\Model\ImageInterface;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
class Block implements BlockInterface
{
    use ToggleableTrait;
    use SectionAssociationTrait;
    use ProductAssociationTrait;
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->initializeSectionsCollection();
        $this->initializeProductsCollection();
    }

    /**
     * @var null|int
     */
    protected $id;

    /**
     * @var null|string
     */
    protected $code;

    /**
     * @var null|string
     */
    protected $type;

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
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): ?string
    {
        return $this->getBlockTranslation()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setName(?string $name): void
    {
        $this->getBlockTranslation()->setName($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): ?string
    {
        return $this->getBlockTranslation()->getContent();
    }

    /**
     * {@inheritdoc}
     */
    public function setContent(?string $content): void
    {
        $this->getBlockTranslation()->setContent($content);
    }

    /**
     * {@inheritdoc}
     */
    public function getImage(): ?ImageInterface
    {
        return $this->getBlockTranslation()->getImage();
    }

    /**
     * {@inheritdoc}
     */
    public function setImage(?ImageInterface $image): void
    {
        $this->getBlockTranslation()->setImage($image);
    }

    /**
     * {@inheritdoc}
     */
    public function getLink(): ?string
    {
        return $this->getBlockTranslation()->getLink();
    }

    /**
     * {@inheritdoc}
     */
    public function setLink(?string $link): void
    {
        $this->getBlockTranslation()->setLink($link);
    }

    /**
     * @return BlockTranslationInterface|TranslationInterface
     */
    protected function getBlockTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    /**
     * {@inheritdoc}
     */
    protected function createTranslation(): BlockTranslation
    {
        return new BlockTranslation();
    }
}
