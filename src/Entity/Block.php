<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Entity;

use BitBag\SyliusCmsPlugin\Entity\Trait\ChannelsAwareTrait;
use BitBag\SyliusCmsPlugin\Entity\Trait\CollectibleTrait;
use BitBag\SyliusCmsPlugin\Entity\Trait\ContentElementsAwareTrait;
use BitBag\SyliusCmsPlugin\Entity\Trait\LocaleAwareTrait;
use BitBag\SyliusCmsPlugin\Entity\Trait\ProductsAwareTrait;
use BitBag\SyliusCmsPlugin\Entity\Trait\ProductsInTaxonsAwareTrait;
use BitBag\SyliusCmsPlugin\Entity\Trait\TaxonAwareTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;

class Block implements BlockInterface
{
    use ToggleableTrait;
    use CollectibleTrait;
    use ChannelsAwareTrait;
    use ContentElementsAwareTrait;
    use LocaleAwareTrait;
    use ProductsAwareTrait;
    use TaxonAwareTrait;
    use ProductsInTaxonsAwareTrait;

    public function __construct()
    {
        $this->initializeCollectionsCollection();
        $this->initializeChannelsCollection();
        $this->initializeContentElementsCollection();
        $this->initializeLocalesCollection();
        $this->initializeProductsCollection();
        $this->initializeTaxonCollection();
        $this->initializeProductsInTaxonsCollection();
    }

    protected ?int $id;

    protected ?string $code = null;

    protected ?string $name;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
