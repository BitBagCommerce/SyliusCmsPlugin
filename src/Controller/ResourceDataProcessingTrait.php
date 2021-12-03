<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\Controller\Helper\FormErrorsFlashHelperInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

trait ResourceDataProcessingTrait
{
    /** @var CacheManager $cacheManager */
    private $cacheManager;

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
        if($media->getPath() === null) {
            return;
        }
        try {
            $file = new File($this->getParameter('sylius_core.public_dir') . $media->getPath());
        }
        catch (FileNotFoundException $exception) {
            $resolvedPath = $this->cacheManager->resolve($media->getPath(), 'sylius_admin_product_original');
            $file = new File($resolvedPath);
        }
        finally {
            if (preg_match("/image\//", $file->getMimeType())) {
                $this->setPathForImageFile($media->getPath());
            }
            else {
                $this->setPathForNonImageFile($media, $file);
            }
        }
    }
    public function setFormErrorsFlashHelper(FormErrorsFlashHelperInterface $formErrorsFlashHelper): void
    {
        $this->formErrorsFlashHelper = $formErrorsFlashHelper;
    }

    public function setCacheManager(CacheManager $cacheManager) {
        $this->cacheManager = $cacheManager;
    }

    private function setPathForImageFile(string $relativePath) {
        $path = $this->cacheManager->resolve($relativePath, 'sylius_admin_product_original');
        echo '';
    }

    private function setPathForNonImageFile(MediaInterface $media, File $file) {
        $fileContents = file_get_contents($file->getPathname());
        Assert::string($fileContents);
        $base64Content = base64_encode($fileContents);
        $path = 'data:' . $file->getMimeType() . ';base64, ' . $base64Content;
        $media->setPath($path);
    }
}
