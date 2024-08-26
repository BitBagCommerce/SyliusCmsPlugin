<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Importer;

use Doctrine\ORM\EntityManagerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterChannelsResolverInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterCollectionsResolverInterface;
use Sylius\CmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class PageImporterSpec extends ObjectBehavior
{
    public function let(
        ResourceResolverInterface $pageResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
    ) {
        $this->beConstructedWith(
            $pageResourceResolver,
            $localeContext,
            $importerCollectionsResolver,
            $importerChannelsResolver,
            $validator,
            $entityManager,
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\Sylius\CmsPlugin\Importer\PageImporter::class);
        $this->shouldImplement(\Sylius\CmsPlugin\Importer\PageImporterInterface::class);
    }

    public function it_imports_page_no_url(
        ResourceResolverInterface $pageResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ImporterChannelsResolverInterface $importerChannelsResolver,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        PageInterface $page,
    ) {
        $row = [
            'code' => 'page_code',
            'name' => 'page_name',
            'enabled' => '1',
            'slug_pl' => 'slug',
            'meta_title_pl' => 'metatitle',
            'meta_keywords_pl' => 'metakeywords',
            'meta_description_pl' => 'metadescription',
            'collections' => 'collections',
            'channels' => 'channels',
        ];

        $pageResourceResolver->getResource('page_code')->willReturn($page);

        $localeContext->getLocaleCode()->willReturn('en_US');

        $page->setCode('page_code')->shouldBeCalled();
        $page->setName('page_name')->shouldBeCalled();
        $page->setEnabled(true)->shouldBeCalled();
        $page->setFallbackLocale('en_US')->shouldBeCalled();

        $page->setCurrentLocale('pl')->shouldBeCalled();

        $page->setSlug('slug')->shouldBeCalled();
        $page->setTitle('metatitle')->shouldBeCalled();
        $page->setMetaKeywords('metakeywords')->shouldBeCalled();
        $page->setMetaDescription('metadescription')->shouldBeCalled();

        $importerCollectionsResolver->resolve($page, 'collections')->shouldBeCalled();
        $importerChannelsResolver->resolve($page, 'channels')->shouldBeCalled();

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
