<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface CollectionInterface extends
    ResourceInterface,
    PagesCollectionInterface,
    BlocksCollectionInterface,
    MediaCollectionInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getType(): ?string;

    public function setType(?string $type): void;

    public function getName(): ?string;

    public function setName(?string $name): void;
}
