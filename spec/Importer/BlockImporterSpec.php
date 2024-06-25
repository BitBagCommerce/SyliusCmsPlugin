<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Importer;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterChannelsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterProductsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterCollectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BlockImporterSpec extends ObjectBehavior
{
    public function let(
        ResourceResolverInterface $blockResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ValidatorInterface $validator,
        BlockRepositoryInterface $blockRepository
    ) {
        $this->beConstructedWith(
            $blockResourceResolver,
            $localeContext,
            $importerCollectionsResolver,
            $importerChannelsResolver,
            $importerProductsResolver,
            $validator,
            $blockRepository
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\BitBag\SyliusCmsPlugin\Importer\BlockImporter::class);
        $this->shouldImplement(\BitBag\SyliusCmsPlugin\Importer\BlockImporterInterface::class);
    }

    public function it_imports_block(
        ResourceResolverInterface $blockResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ValidatorInterface $validator,
        BlockRepositoryInterface $blockRepository,
        BlockInterface $block
    )
    {
        $row = ['name_pl' => 'name', 'content_pl' => 'content', 'link_pl' => 'link', 'code' => 'block_code'];

        $blockResourceResolver->getResource('block_code')->willReturn($block);

        $localeContext->getLocaleCode()->willReturn('en_US');

        $block->setCode('block_code')->shouldBeCalled();
        $block->setFallbackLocale('en_US')->shouldBeCalled();
        $block->setCurrentLocale('pl')->shouldBeCalled();
        $block->setName('name')->shouldBeCalled();
        $block->setLink('link')->shouldBeCalled();
        $block->setContent('content')->shouldBeCalled();

        $importerCollectionsResolver->resolve($block, null)->shouldBeCalled();
        $importerChannelsResolver->resolve($block, null)->shouldBeCalled();
        $importerProductsResolver->resolve($block, null)->shouldBeCalled();

        $validator->validate($block, null, ['bitbag'])->willReturn(new ConstraintViolationList());

        $blockRepository->add($block)->shouldBeCalled();

        $this->import($row);
    }

    public function it_gets_resource_code()
    {
        $this->getResourceCode()->shouldReturn('block');
    }
}
