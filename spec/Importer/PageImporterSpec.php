<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Importer;

use BitBag\SyliusCmsPlugin\Downloader\ImageDownloaderInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterChannelsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterProductsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterCollectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class PageImporterSpec extends ObjectBehavior
{
    public function let(
        ResourceResolverInterface $pageResourceResolver,
        LocaleContextInterface $localeContext,
        ImageDownloaderInterface $imageDownloader,
        FactoryInterface $mediaFactory,
        MediaProviderResolverInterface $mediaProviderResolver,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager
    ) {
        $this->beConstructedWith(
            $pageResourceResolver,
            $localeContext,
            $imageDownloader,
            $mediaFactory,
            $mediaProviderResolver,
            $importerCollectionsResolver,
            $importerChannelsResolver,
            $importerProductsResolver,
            $validator,
            $entityManager,
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\BitBag\SyliusCmsPlugin\Importer\PageImporter::class);
        $this->shouldImplement(\BitBag\SyliusCmsPlugin\Importer\PageImporterInterface::class);
    }

    public function it_imports_page_no_url(
        ResourceResolverInterface $pageResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        PageInterface $page,
    )
    {
        $row = [
            'code' => 'page_code',
            'slug_pl' => 'slug',
            'name_pl' => 'name',
            'image_pl' => null,
            'imagecode_pl' => 'imagecode',
            'metakeywords_pl' => 'metakeywords',
            'metadescription_pl' => 'metadescription',
            'content_pl' => 'content',
            'breadcrumb_pl' => 'breadcrumb',
            'namewhenlinked_pl' => 'namewhenlinked',
            'descriptionwhenlinked_pl' => 'descriptionwhenlinked',
            'collections' => 'collections',
            'channels' => 'channels',
            'products' => 'products',
        ];

        $pageResourceResolver->getResource('page_code')->willReturn($page);

        $localeContext->getLocaleCode()->willReturn('en_US');

        $page->setCode('page_code')->shouldBeCalled();
        $page->setFallbackLocale('en_US')->shouldBeCalled();

        $page->setCurrentLocale('pl')->shouldBeCalled();

        $page->setSlug('slug')->shouldBeCalled();
        $page->setName('name')->shouldBeCalled();
        $page->setMetaKeywords('metakeywords')->shouldBeCalled();
        $page->setMetaDescription('metadescription')->shouldBeCalled();
        $page->setContent('content')->shouldBeCalled();
        $page->setBreadcrumb('breadcrumb')->shouldBeCalled();
        $page->setNameWhenLinked('namewhenlinked')->shouldBeCalled();
        $page->setDescriptionWhenLinked('descriptionwhenlinked')->shouldBeCalled();

        $importerCollectionsResolver->resolve($page, 'collections')->shouldBeCalled();
        $importerChannelsResolver->resolve($page, 'channels')->shouldBeCalled();
        $importerProductsResolver->resolve($page, 'products')->shouldBeCalled();

        $validator->validate($page, null, ['bitbag'])->willReturn(new ConstraintViolationList());

        $entityManager->persist($page)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();

        $this->import($row);
    }

    public function it_gets_resource_code()
    {
        $this->getResourceCode()->shouldReturn('page');
    }
}
