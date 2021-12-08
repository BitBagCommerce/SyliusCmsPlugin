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
    private function getResourceInterface(Request $request): object
    {
        return null !== $request->get('id') && $this->repository->find($request->get('id')) ?
            $this->repository->find($request->get('id')) :
            $this->factory->createNew();
    }

    private function getFormForResource(RequestConfiguration $configuration, ResourceInterface $resource): FormInterface
    {
        return $this->resourceFormFactory->create($configuration, $resource);
    }

    private function getRequestConfiguration(Request $request): RequestConfiguration
    {
        return $this->requestConfigurationFactory->create($this->metadata, $request);
    }

    private function setResourceMediaPath(MediaInterface $media): void
    {
        if (null === $media->getPath()) {
            return;
        }
        Assert::notNull($media->getMimeType());
        if (1 === preg_match("/image\//", $media->getMimeType())) {
            $this->setPathForImageFile($media);
        } else {
            $this->setPathForNonImageFile($media);
        }
    }

    private function setPathForImageFile(MediaInterface $media): void
    {
        Assert::string($media->getPath());
        if (!$this->cacheManager->isStored($media->getPath(), $this::FILTER)) {
            $this->cacheManager->store($this->dataManager->find($this::FILTER, $media->getPath()), $media->getPath(), $this::FILTER);
        }
        $resolvedPath = $this->cacheManager->resolve($media->getPath(), $this::FILTER);
        $fileContents = file_get_contents($resolvedPath);
        Assert::string($fileContents);
        $this->setFileContentsAsMediaPath($media, $fileContents);
    }

    private function setPathForNonImageFile(MediaInterface $media): void
    {
        Assert::string($media->getPath());
        Assert::string($this->getParameter('sylius_core.public_dir'));
        $file = new File($this->getParameter('sylius_core.public_dir') . $media->getPath());
        $fileContents = file_get_contents($file->getPathname());
        Assert::string($fileContents);
        $this->setFileContentsAsMediaPath($media, $fileContents);
    }

    private function setFileContentsAsMediaPath(MediaInterface $media, string $fileContents): void
    {
        $base64Content = base64_encode($fileContents);
        $path = 'data:' . $media->getMimeType() . ';base64, ' . $base64Content;
        $media->setPath($path);
    }
}
