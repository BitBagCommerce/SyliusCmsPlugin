<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class Block implements BlockInterface
{
    use ToggleableTrait;

    use SectionableTrait;

    use ProductsAwareTrait;

    use TaxonAwareTrait;

    use ChannelsAwareTrait;

    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->initializeTranslationsCollection();
        $this->initializeSectionsCollection();
        $this->initializeProductsCollection();
        $this->initializeTaxonCollection();
        $this->initializeChannelsCollection();
    }

    /** @var int */
    protected $id;

    /** @var string */
    protected $code;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        assert(null !== $code);
        $this->code = $code;
    }

    public function getName(): ?string
    {
        /** @var BlockTranslationInterface $blockTranslationInterface */
        $blockTranslationInterface = $this->getBlockTranslation();

        return $blockTranslationInterface->getName();
    }

    public function setName(?string $name): void
    {
        /** @var BlockTranslationInterface $blockTranslationInterface */
        $blockTranslationInterface = $this->getBlockTranslation();
        $blockTranslationInterface->setName($name);
    }

    public function getContent(): ?string
    {
        /** @var BlockTranslationInterface $blockTranslationInterface */
        $blockTranslationInterface = $this->getBlockTranslation();

        return $blockTranslationInterface->getContent();
    }

    public function setContent(?string $content): void
    {
        /** @var BlockTranslationInterface $blockTranslationInterface */
        $blockTranslationInterface = $this->getBlockTranslation();
        $blockTranslationInterface->setContent($content);
    }

    public function getLink(): ?string
    {
        /** @var BlockTranslationInterface $blockTranslationInterface */
        $blockTranslationInterface = $this->getBlockTranslation();

        return $blockTranslationInterface->getLink();
    }

    public function setLink(?string $link): void
    {
        /** @var BlockTranslationInterface $blockTranslationInterface */
        $blockTranslationInterface = $this->getBlockTranslation();
        $blockTranslationInterface->setLink($link);
    }

    /**
     * @return BlockTranslationInterface|TranslationInterface
     */
    protected function getBlockTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): BlockTranslationInterface
    {
        return new BlockTranslation();
    }
}
