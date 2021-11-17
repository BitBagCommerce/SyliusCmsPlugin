<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller\Action\Admin;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use Sylius\Component\Core\Formatter\StringInflector;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class UploadEditorImageAction
{
    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    /** @var MediaRepositoryInterface */
    private $mediaRepository;

    /** @var FactoryInterface */
    private $mediaFactory;

    public function __construct(
        MediaProviderResolverInterface $mediaProviderResolver,
        MediaRepositoryInterface $mediaRepository,
        FactoryInterface $mediaFactory
    ) {
        $this->mediaProviderResolver = $mediaProviderResolver;
        $this->mediaRepository = $mediaRepository;
        $this->mediaFactory = $mediaFactory;
    }

    public function __invoke(Request $request): Response
    {
        /** @var UploadedFile $image */
        $image = $request->files->get('upload');

        if (null == $image || !$this->isValidImage($image)) {
            throw new BadRequestHttpException();
        }

        $media = $this->createMedia($image);

        return new JsonResponse([
            'uploaded' => 1,
            'fileName' => $image->getFilename(),
            'url' => $media->getPath(),
        ]);
    }

    private function isValidImage(UploadedFile $image): bool
    {
        return in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'], true);
    }

    private function createMedia(UploadedFile $image): MediaInterface
    {
        /** @var MediaInterface $media */
        $media = $this->mediaFactory->createNew();
        $code = $this->createMediaCode(pathinfo($image->getClientOriginalName())['filename']);

        $media->setFile($image);
        $media->setCode($code);
        $media->setType(MediaInterface::IMAGE_TYPE);

        $this->mediaProviderResolver->resolveProvider($media)->upload($media);
        $this->mediaRepository->add($media);

        return $media;
    }

    private function createMediaCode(string $name): string
    {
        $code = StringInflector::nameToCode($name);
        $i = 0;

        do {
            if (0 < $i) {
                $code = $code . '_image_' . (string) $i;
            }

            ++$i;
        } while (0 < count($this->mediaRepository->findBy(['code' => $code])));

        return $code;
    }
}
