<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Controller\Action\Admin;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Controller\Action\Admin\UploadEditorImageAction;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\MediaProvider\ProviderInterface;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Sylius\CmsPlugin\Resolver\MediaProviderResolverInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

final class UploadEditorImageActionSpec extends ObjectBehavior
{
    public function let(
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaRepositoryInterface $mediaRepository,
        FactoryInterface $mediaFactory,
    ) {
        $this->beConstructedWith($mediaProviderResolver, $mediaRepository, $mediaFactory);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UploadEditorImageAction::class);
    }

    public function it_uploads_media(
        Request $request,
        FactoryInterface $mediaFactory,
        MediaInterface $media,
        FileBag $fileBag,
        MediaProviderResolverInterface $mediaProviderResolver,
        ProviderInterface $provider,
        MediaRepositoryInterface $mediaRepository,
    ): void {
        $uploadedFile = new UploadedFile(__DIR__ . '/../../../../tests/Behat/Resources/images/aston_martin_db_11.jpg', 'aston_martin_db_11.jpg');

        $request->files = $fileBag;

        $fileBag->get('upload')->willReturn($uploadedFile);
        $mediaFactory->createNew()->willReturn($media);
        $mediaProviderResolver->resolveProvider($media)->willReturn($provider);
        $mediaRepository->findBy(['code' => 'aston_martin_db_11'])->willReturn([]);
        $mediaRepository->add($media)->shouldBeCalled();

        $this->__invoke($request);
    }
}
