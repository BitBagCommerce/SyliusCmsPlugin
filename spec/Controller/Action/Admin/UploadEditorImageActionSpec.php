<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Controller\Action\Admin;

use BitBag\SyliusCmsPlugin\Controller\Action\Admin\UploadEditorImageAction;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Media\Provider\ProviderInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

final class UploadEditorImageActionSpec extends ObjectBehavior
{
    function let(
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaRepositoryInterface $mediaRepository,
        FactoryInterface $mediaFactory
    ) {
        $this->beConstructedWith($mediaProviderResolver, $mediaRepository, $mediaFactory);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(UploadEditorImageAction::class);
    }

    function it_uploads_media(
        Request $request,
        FactoryInterface $mediaFactory,
        MediaInterface $media,
        FileBag $fileBag,
        MediaProviderResolverInterface $mediaProviderResolver,
        ProviderInterface $provider
    ): void {
        $uploadedFile = new UploadedFile(__DIR__ . '/../../../../tests/Behat/Resources/media/aston_martin_db_11.jpg', 'aston_martin_db_11.jpg');

        $request->files = $fileBag;

        $fileBag->get('upload')->willReturn($uploadedFile);
        $mediaFactory->createNew()->willReturn($media);
        $mediaProviderResolver->resolveProvider($media)->willReturn($provider);

        $this->__invoke($request);
    }
}
