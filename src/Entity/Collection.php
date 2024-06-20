<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class Collection implements CollectionInterface
{
    use PageableTrait;
    use BlockableTrait;
    use MediableTrait;
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    protected ?int $id;

    protected ?string $code = null;

    protected ?string $type = null;

    public function __construct()
    {
        $this->initializePagesCollection();
        $this->initializeBlocksCollection();
        $this->initializeMediaCollection();
        $this->initializeTranslationsCollection();
    }

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
        $this->code = $code;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getName(): ?string
    {
        /** @var CollectionTranslationInterface $collectionTranslationInterface */
        $collectionTranslationInterface = $this->getCollectionTranslation();

        return $collectionTranslationInterface->getName();
    }

    public function setName(?string $name): void
    {
        /** @var CollectionTranslationInterface $collectionTranslationInterface */
        $collectionTranslationInterface = $this->getCollectionTranslation();
        $collectionTranslationInterface->setName($name);
    }

    /**
     * @return TranslationInterface|CollectionTranslationInterface
     */
    protected function getCollectionTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): TranslationInterface
    {
        return new CollectionTranslation();
    }
}
