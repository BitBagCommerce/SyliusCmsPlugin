<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\Controller\Helper\FormErrorsFlashHelperInterface;
use BitBag\SyliusCmsPlugin\Entity\Media;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolver;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

abstract class ResourceDataProcessingController extends ResourceController
{
    /** @var ResourceResolverInterface */
    protected $resourceResolver;

    /** @var FormErrorsFlashHelperInterface */
    protected $formErrorsFlashHelper;

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

    protected function setResourcePath(MediaInterface $resource): void {
        /** @var string|null $resourcePath */
        $resourcePath = $resource->getPath();
        Assert::notNull($resourcePath);
        Assert::string($this->getParameter('sylius_core.public_dir'));
        $file = $resource->getFile() ?? new File($this->getParameter('sylius_core.public_dir') . '/' . $resource->getPath());
        $fileContents = file_get_contents($file->getPathname());
        if (is_string($fileContents)) {
            $base64Content = base64_encode($fileContents);
            $path = 'data:' . $file->getMimeType() . ';base64, ' . $base64Content;
        } else {
            $path = 'Path error';
        }
        $resource->setPath($path);
    }

    /**
     * @required
     */
    public function setResourceResolver(ResourceResolver $resourceResolver): void
    {
        $this->resourceResolver = $resourceResolver;
    }

    /**
     * @required
     */
    public function setFormErrorsFlashHelper(FormErrorsFlashHelperInterface $formErrorsFlashHelper): void
    {
        $this->formErrorsFlashHelper = $formErrorsFlashHelper;
    }
}
