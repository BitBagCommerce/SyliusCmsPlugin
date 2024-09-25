<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Controller;

use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;
use Sylius\CmsPlugin\Resolver\PageResourceResolverInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class PageController extends ResourceController
{
    use ResourceDataProcessingTrait;
    use MediaPageControllersCommonDependencyInjectionsTrait;

    private PageResourceResolverInterface $pageResourceResolver;

    public const FILTER = 'sylius_admin_product_original';

    public const DEFAULT_TEMPLATE = '@SyliusCmsPlugin/Shop/Page/show.html.twig';

    public function showAction(Request $request): Response
    {
        $configuration = $this->getRequestConfiguration($request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $slug = $request->attributes->get('slug');

        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->get('sylius_cms.repository.page');

        /** @var LocaleContextInterface $localeContext */
        $localeContext = $this->get('sylius.context.locale');

        /** @var ChannelContextInterface $channelContext */
        $channelContext = $this->get('sylius.context.channel');

        Assert::notNull($channelContext->getChannel()->getCode());

        $page = $pageRepository->findOneEnabledBySlugAndChannelCode(
            $slug,
            $localeContext->getLocaleCode(),
            $channelContext->getChannel()->getCode(),
        );

        if (null === $page) {
            throw $this->createNotFoundException('Page not found');
        }

        return $this->render($page->getTemplate() ?? self::DEFAULT_TEMPLATE, [
            'page' => $page,
        ]);
    }

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
            'template' => $page->getTemplate() ?? self::DEFAULT_TEMPLATE,
            $this->metadata->getName() => $page,
        ]);
    }

    public function setPageResourceResolver(PageResourceResolverInterface $pageResourceResolver): void
    {
        $this->pageResourceResolver = $pageResourceResolver;
    }
}
