<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

trait ResourceDataProcessingTrait
{
    protected function getResourceInterface(Request $request): object
    {
        return null !== $request->get('id') && $this->repository->find($request->get('id')) ?
            $this->repository->find($request->get('id')) :
            $this->factory->createNew();
    }

    protected function getFormForResource(RequestConfiguration $configuration, ResourceInterface $resource): FormInterface
    {
        return $this->resourceFormFactory->create($configuration, $resource);
    }

    protected function getRequestConfiguration(Request $request): RequestConfiguration
    {
        return $this->requestConfigurationFactory->create($this->metadata, $request);
    }

    protected function setResourceMediaPath(MediaInterface $media): void
    {
        /** @var string|null $mediaPath */
        $mediaPath = $media->getPath();
        Assert::notNull($mediaPath, 'Media path is null');
        Assert::string($this->getParameter('sylius_core.public_dir'));
//        $filePath = $this->getParameter('sylius_core.public_dir') . '/' . $media->getPath();
//        $this->cacheResolver->isStored($filePath) ?
//            $file = $this->cacheResolver->resolve($filePath) :
//            $file = $media->getFile();
        $file = $media->getFile() ?? new File($this->getParameter('sylius_core.public_dir') . '/' . $media->getPath());
        $fileContents = file_get_contents($file->getPathname());
        if (is_string($fileContents)) {
            $base64Content = base64_encode($fileContents);
            $path = 'data:' . $file->getMimeType() . ';base64, ' . $base64Content;
        } else {
            $path = 'Path error';
        }
        $media->setPath($path);
    }
}
