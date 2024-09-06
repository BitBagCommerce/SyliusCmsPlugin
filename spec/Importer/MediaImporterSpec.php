<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Importer;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Sylius\CmsPlugin\Resolver\Importer\ImporterCollectionsResolverInterface;
use Sylius\CmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class MediaImporterSpec extends ObjectBehavior
{
    public function let(
        ResourceResolverInterface $mediaResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ValidatorInterface $validator,
        MediaRepositoryInterface $mediaRepository,
    ) {
        $this->beConstructedWith(
            $mediaResourceResolver,
            $localeContext,
            $importerCollectionsResolver,
            $validator,
            $mediaRepository,
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\Sylius\CmsPlugin\Importer\MediaImporter::class);
        $this->shouldImplement(\Sylius\CmsPlugin\Importer\MediaImporterInterface::class);
    }

    public function it_imports_media(
        ResourceResolverInterface $mediaResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterCollectionsResolverInterface $importerCollectionsResolver,
        ValidatorInterface $validator,
        MediaRepositoryInterface $mediaRepository,
        MediaInterface $media,
    ) {
        $row = ['name_pl' => 'name', 'content_pl' => 'content', 'alt_pl' => 'alt', 'code' => 'media_code'];

        $mediaResourceResolver->getResource('media_code')->willReturn($media);
        $localeContext->getLocaleCode()->willReturn('en_US');

        $media->setCode('media_code')->shouldBeCalled();
        $media->setType(null)->shouldBeCalled();
        $media->setFallbackLocale('en_US')->shouldBeCalled();
        $media->setCurrentLocale('pl')->shouldBeCalled();
        $media->setName('name')->shouldBeCalled();
        $media->setContent('content')->shouldBeCalled();
        $media->setAlt('alt')->shouldBeCalled();

        $importerCollectionsResolver->resolve($media, null)->shouldBeCalled();

        $validator->validate($media, null, ['cms'])->willReturn(new ConstraintViolationList());

        $mediaRepository->add($media)->shouldBeCalled();

        $this->import($row);
    }

    public function it_gets_resource_code()
    {
        $this->getResourceCode()->shouldReturn('media');
    }
}
