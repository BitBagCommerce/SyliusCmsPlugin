<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\CmsPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
trait ProductAssociationTrait
{
    /**
     * @var Collection|ProductInterface[]
     */
    protected $products;

    public function initializeProductsCollection()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return Collection|ProductInterface[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param ProductInterface $product
     *
     * @return bool
     */
    public function hasProduct(ProductInterface $product)
    {
        return $this->products->contains($product);
    }

    /**
     * @param ProductInterface $product
     */
    public function addProduct(ProductInterface $product)
    {
        $this->products->add($product);
    }

    /**
     * @param ProductInterface $product
     */
    public function removeProduct(ProductInterface $product)
    {
        if (true === $this->hasProduct($product)) {
            $this->products->removeElement($product);
        }
    }
}
