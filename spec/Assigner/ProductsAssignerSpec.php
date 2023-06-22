<?php

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Assigner;

use BitBag\SyliusCmsPlugin\Assigner\ProductsAssigner;
use BitBag\SyliusCmsPlugin\Assigner\ProductsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\ProductsAwareInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;

final class ProductsAssignerSpec extends ObjectBehavior
{
    public function let(ProductRepositoryInterface $productRepository): void
    {
        $this->beConstructedWith($productRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductsAssigner::class);
    }

    public function it_implements_products_assigner_interface(): void
    {
        $this->shouldHaveType(ProductsAssignerInterface::class);
    }

    public function it_assigns_products(
        ProductRepositoryInterface $productRepository,
        ProductInterface $mugProduct,
        ProductInterface $tshirtProduct,
        ProductsAwareInterface $productsAware
    ): void {
        $productRepository->findOneBy(['code' => 'mug'])->willReturn($mugProduct);
        $productRepository->findOneBy(['code' => 't-shirt'])->willReturn($tshirtProduct);

        $productsAware->addProduct($mugProduct)->shouldBeCalled();
        $productsAware->addProduct($tshirtProduct)->shouldBeCalled();

        $this->assign($productsAware, ['mug', 't-shirt']);
    }
}
