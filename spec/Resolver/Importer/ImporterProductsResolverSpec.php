<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Resolver\Importer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\CmsPlugin\Assigner\ProductsAssignerInterface;
use Sylius\CmsPlugin\Entity\ProductsAwareInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterProductsResolver;

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
        ProductsAwareInterface $productsAware,
    ) {
        $productsRow = 'product1, product2, product3';
        $productsCodes = ['product1', 'product2', 'product3'];

        $productsAssigner->assign($productsAware, $productsCodes)->shouldBeCalled();

        $this->resolve($productsAware, $productsRow);
    }

    public function it_skips_resolution_when_products_row_is_null(
        ProductsAssignerInterface $productsAssigner,
        ProductsAwareInterface $productsAware,
    ) {
        $productsRow = null;

        $productsAssigner->assign($productsAware, Argument::any())->shouldNotBeCalled();

        $this->resolve($productsAware, $productsRow);
    }
}
