<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin;

use BitBag\SyliusCmsPlugin\Controller\Helper\FormErrorsFlashHelperInterface;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolver;
use BitBag\SyliusCmsPlugin\Resolver\ResourceResolverInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class CustomResourceController extends ResourceController
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
