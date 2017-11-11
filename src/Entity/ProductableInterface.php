<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
interface ProductableInterface
{
    public function initializeProductsCollection(): void;

    /**
     * @return Collection|ProductInterface[]
     */
    public function getProducts(): Collection;

    /**
     * @param ProductInterface $product
     *
     * @return bool
     */
    public function hasProduct(ProductInterface $product): bool;

    /**
     * @param ProductInterface $product
     */
    public function addProduct(ProductInterface $product): void;

    /**
     * @param ProductInterface $product
     */
    public function removeProduct(ProductInterface $product): void;
}