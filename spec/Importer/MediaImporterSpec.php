<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Importer;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterProductsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ImporterSectionsResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class MediaImporterSpec extends ObjectBehavior
{
    public function let(
        ResourceResolverInterface $mediaResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterSectionsResolverInterface $importerSectionsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ValidatorInterface $validator,
        MediaRepositoryInterface $mediaRepository
    ) {
        $this->beConstructedWith(
            $mediaResourceResolver,
            $localeContext,
            $importerSectionsResolver,
            $importerProductsResolver,
            $validator,
            $mediaRepository,
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(\BitBag\SyliusCmsPlugin\Importer\MediaImporter::class);
        $this->shouldImplement(\BitBag\SyliusCmsPlugin\Importer\MediaImporterInterface::class);
    }

    public function it_imports_media(
        ResourceResolverInterface $mediaResourceResolver,
        LocaleContextInterface $localeContext,
        ImporterSectionsResolverInterface $importerSectionsResolver,
        ImporterProductsResolverInterface $importerProductsResolver,
        ValidatorInterface $validator,
        MediaRepositoryInterface $mediaRepository,
        MediaInterface $media
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

        $importerSectionsResolver->resolve($media, null)->shouldBeCalled();
        $importerProductsResolver->resolve($media, null)->shouldBeCalled();

        $validator->validate($media, null, ['bitbag'])->willReturn(new ConstraintViolationList());

        $mediaRepository->add($media)->shouldBeCalled();

        $this->import($row);
    }

    public function it_gets_resource_code()
    {
        $this->getResourceCode()->shouldReturn('media');
    }
}
