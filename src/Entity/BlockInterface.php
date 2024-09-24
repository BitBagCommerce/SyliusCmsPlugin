<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;

interface BlockInterface extends
    ResourceInterface,
    ToggleableInterface,
    CollectibleInterface,
    ChannelsAwareInterface,
    ContentElementsAwareInterface,
    ProductsAwareInterface,
    TaxonAwareInterface,
    ProductsInTaxonsAwareInterface,
    BlockTaxonAwareInterface,
    BlockProductAwareInterface
{
    public function getCode(): ?string;

    public function setCode(?string $code): void;

    public function getName(): ?string;

    public function setName(?string $name): void;
}
