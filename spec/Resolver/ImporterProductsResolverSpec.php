<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Assigner\ProductsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\ProductsAwareInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterProductsResolver;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

final class ImporterProductsResolverSpec extends ObjectBehavior
{
    public function let(ProductsAssignerInterface $productsAssigner)
    {
        $this->beConstructedWith($productsAssigner);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(ImporterProductsResolver::class);
    }

    public function it_resolves_products_for_products_aware(
        ProductsAssignerInterface $productsAssigner,
        ProductsAwareInterface $productsAware
    ) {
        $productsRow = 'product1, product2, product3';
        $productsCodes = ['product1', 'product2', 'product3'];

        $productsAssigner->assign($productsAware, $productsCodes)->shouldBeCalled();

        $this->resolve($productsAware, $productsRow);
    }

    public function it_skips_resolution_when_products_row_is_null(
        ProductsAssignerInterface $productsAssigner,
        ProductsAwareInterface $productsAware
    ) {
        $productsRow = null;

        $productsAssigner->assign($productsAware, Argument::any())->shouldNotBeCalled();

        $this->resolve($productsAware, $productsRow);
    }
}
