<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
trait ProductsAwareTrait
{
    /**
     * @var Collection|ProductInterface[]
     */
    protected $products;

    public function initializeProductsCollection(): void
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return Collection|ProductInterface[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param ProductInterface $product
     *
     * @return bool
     */
    public function hasProduct(ProductInterface $product): bool
    {
        return $this->products->contains($product);
    }

    /**
     * @param ProductInterface $product
     */
    public function addProduct(ProductInterface $product): void
    {
        $this->products->add($product);
    }

    /**
     * @param ProductInterface $product
     */
    public function removeProduct(ProductInterface $product): void
    {
        if (true === $this->hasProduct($product)) {
            $this->products->removeElement($product);
        }
    }
}
