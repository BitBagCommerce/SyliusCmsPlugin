<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Importer;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Importer\BlockImporter;
use Sylius\CmsPlugin\Importer\BlockImporterInterface;
use Sylius\CmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterChannelsResolverInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterCollectionsResolverInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterLocalesResolverInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterProductsInTaxonsResolverInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterProductsResolverInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterTaxonsResolverInterface;
use Sylius\CmsPlugin\Resolver\ResourceResolverInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BlockImporterSpec extends ObjectBehavior
{
    public function let(
        ResourceResolverInterface $blockResourceResolver,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ImporterLocalesResolverInterface $importerLocalesResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ImporterTaxonsResolverInterface $importerTaxonsResolver,
        ImporterProductsInTaxonsResolverInterface $importerProductsInTaxonsResolver,
        ValidatorInterface $validator,
        BlockRepositoryInterface $blockRepository,
    ) {
        $this->beConstructedWith(
            $blockResourceResolver,
            $importerCollectionsResolver,
            $importerChannelsResolver,
            $importerLocalesResolver,
            $importerProductsResolver,
            $importerTaxonsResolver,
            $importerProductsInTaxonsResolver,
            $validator,
            $blockRepository,
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(BlockImporter::class);
        $this->shouldImplement(BlockImporterInterface::class);
    }

    public function it_imports_block(
        ResourceResolverInterface $blockResourceResolver,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ImporterLocalesResolverInterface $importerLocalesResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ImporterTaxonsResolverInterface $importerTaxonsResolver,
        ImporterProductsInTaxonsResolverInterface $importerProductsInTaxonsResolver,
        ValidatorInterface $validator,
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block,
    ) {
        $row = ['name' => 'block_name', 'code' => 'block_code', 'enabled' => '1'];

        $blockResourceResolver->getResource('block_code')->willReturn($block);

        $block->setCode('block_code')->shouldBeCalled();
        $block->setName('block_name')->shouldBeCalled();
        $block->setEnabled(true)->shouldBeCalled();

        $importerCollectionsResolver->resolve($block, null)->shouldBeCalled();
        $importerChannelsResolver->resolve($block, null)->shouldBeCalled();
        $importerLocalesResolver->resolve($block, null)->shouldBeCalled();
        $importerProductsResolver->resolve($block, null)->shouldBeCalled();
        $importerTaxonsResolver->resolve($block, null)->shouldBeCalled();
        $importerProductsInTaxonsResolver->resolve($block, null)->shouldBeCalled();

        $validator->validate($block, null, ['bitbag'])->willReturn(new ConstraintViolationList());

        $blockRepository->add($block)->shouldBeCalled();

        $this->import($row);
    }

    public function it_gets_resource_code()
    {
        $this->getResourceCode()->shouldReturn('block');
    }
}
