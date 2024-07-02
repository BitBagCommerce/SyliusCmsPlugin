<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Resolver\PageResourceResolverInterface;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class PageController extends ResourceController
{
    use ResourceDataProcessingTrait;
    use MediaPageControllersCommonDependencyInjectionsTrait;

    /** @var PageResourceResolverInterface */
    private $pageResourceResolver;

    public const FILTER = 'sylius_admin_product_original';

    public function renderLinkAction(Request $request): Response
    {
        $configuration = $this->getRequestConfiguration($request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');

        $page = $this->pageResourceResolver->findOrLog($code);

        if (null === $page) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $page);

        if ($configuration->isHtmlRequest()) {
            return $this->render($configuration->getTemplate(ResourceActions::SHOW . '.html'), [
                'configuration' => $configuration,
                'metadata' => $this->metadata,
                'resource' => $page,
                $this->metadata->getName() => $page,
            ]);
        }

        Assert::true(null !== $this->viewHandler);

        return $this->viewHandler->handle($configuration, View::create($page));
    }

    public function previewAction(Request $request): Response
    {
        $configuration = $this->getRequestConfiguration($request);

        $this->isGrantedOr403($configuration, ResourceActions::CREATE);

        /** @var PageInterface $page */
        $page = $this->getResourceInterface($request);
        $form = $this->getFormForResource($configuration, $page);
        $defaultLocale = $this->getParameter('locale');

        $form->handleRequest($request);

        $page->setFallbackLocale($request->get('_locale', $defaultLocale));
        $page->setCurrentLocale($request->get('_locale', $defaultLocale));

        $this->formErrorsFlashHelper->addFlashErrors($form);

        if (!$configuration->isHtmlRequest()) {
            Assert::true(null !== $this->viewHandler);
            $this->viewHandler->handle($configuration, View::create($page));
        }

        return $this->render($configuration->getTemplate(ResourceActions::CREATE . '.html'), [
            'resource' => $page,
            'preview' => true,
            $this->metadata->getName() => $page,
        ]);
    }

    public function setPageResourceResolver(PageResourceResolverInterface $pageResourceResolver): void
    {
        $this->pageResourceResolver = $pageResourceResolver;
    }
}
