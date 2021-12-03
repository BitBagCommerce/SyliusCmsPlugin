<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\Controller\Helper\FormErrorsFlashHelperInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Liip\ImagineBundle\Imagine\Cache\Resolver\ResolverInterface;
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
        $path = $this->getParameter('sylius_core.public_dir') . '/' . $media->getPath();
        Assert::string(parse_url($path, PHP_URL_PATH));
        $resolvedPath = $this->cacheResolver->resolve(parse_url($path, PHP_URL_PATH), 'sylius_shop_product_original');
        $file = new File($resolvedPath);
        $fileContent = $file->getContent();
        $base64Content = base64_encode($fileContent);
        $path = 'data:' . $file->getMimeType() . ';base64, ' . $base64Content;
        $media->setPath($path);
    }

    public function setCacheResolver(ResolverInterface $cacheResolver): void
    {
        $this->cacheResolver = $cacheResolver;
    }

    public function setFormErrorsFlashHelper(FormErrorsFlashHelperInterface $formErrorsFlashHelper): void
    {
        $this->formErrorsFlashHelper = $formErrorsFlashHelper;
    }
}
