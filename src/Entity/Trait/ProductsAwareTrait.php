<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Entity\Trait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;

trait ProductsAwareTrait
{
    protected Collection $products;

    public function initializeProductsCollection(): void
    {
        $this->products = new ArrayCollection();
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function hasProduct(ProductInterface $product): bool
    {
        return $this->products->contains($product);
    }

    public function addProduct(ProductInterface $product): void
    {
        if (false === $this->hasProduct($product)) {
            $this->products->add($product);
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        if (true === $this->hasProduct($product)) {
            $this->products->removeElement($product);
        }
    }

    public function canBeDisplayedForProduct(ProductInterface $product): bool
    {
        return $this->hasProduct($product);
    }
}
