<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity;

use Sylius\CmsPlugin\Entity\Trait\ChannelsAwareTrait;
use Sylius\CmsPlugin\Entity\Trait\CollectibleTrait;
use Sylius\CmsPlugin\Entity\Trait\ContentElementsAwareTrait;
use Sylius\CmsPlugin\Entity\Trait\ProductsAwareTrait;
use Sylius\CmsPlugin\Entity\Trait\ProductsInTaxonsAwareTrait;
use Sylius\CmsPlugin\Entity\Trait\TaxonAwareTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;

class Block implements BlockInterface
{
    use ToggleableTrait;
    use CollectibleTrait;
    use ChannelsAwareTrait;
    use ContentElementsAwareTrait;
    use ProductsAwareTrait;
    use TaxonAwareTrait;
    use ProductsInTaxonsAwareTrait;

    public function __construct()
    {
        $this->initializeCollectionsCollection();
        $this->initializeChannelsCollection();
        $this->initializeContentElementsCollection();
        $this->initializeProductsCollection();
        $this->initializeTaxonCollection();
        $this->initializeProductsInTaxonsCollection();
    }

    protected ?int $id;

    protected ?string $code = null;

    protected ?string $name;

    protected ?string $template = null;

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

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(?string $template): void
    {
        $this->template = $template;
    }
}
