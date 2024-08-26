<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\CmsPlugin\Entity\Trait\BlocksCollectionTrait;
use Sylius\CmsPlugin\Entity\Trait\MediaCollectionTrait;
use Sylius\CmsPlugin\Entity\Trait\PagesCollectionTrait;

class Collection implements CollectionInterface
{
    use PagesCollectionTrait;
    use BlocksCollectionTrait;
    use MediaCollectionTrait;

    protected ?int $id;

    protected ?string $code = null;

    protected ?string $name = null;

    protected ?string $type = null;

    public function __construct()
    {
        $this->initializePagesCollection();
        $this->initializeBlocksCollection();
        $this->initializeMediaCollection();
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
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
