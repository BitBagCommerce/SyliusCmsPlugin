<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Controller;

use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\CmsPlugin\Entity\BlockInterface;
use Sylius\CmsPlugin\Renderer\ContentElementRendererStrategyInterface;
use Sylius\CmsPlugin\Resolver\BlockResourceResolverInterface;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class BlockController extends ResourceController
{
    public const BLOCK_TEMPLATE = '@SyliusCmsPlugin/Shop/Block/show.html.twig';

    public function renderBlockAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');
        /** @var BlockResourceResolverInterface $blockResourceResolver */
        $blockResourceResolver = $this->get('sylius_cms.resolver.block_resource');
        $block = $blockResourceResolver->findOrLog($code);

        if (null === $block) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $block);

        if (!$configuration->isHtmlRequest()) {
            Assert::true(null !== $this->viewHandler);

            return $this->viewHandler->handle($configuration, View::create($block));
        }

        return $this->render($block->getTemplate() ?? self::BLOCK_TEMPLATE, [
            'configuration' => $configuration,
            'metadata' => $this->metadata,
            'resource' => $block,
            $this->metadata->getName() => $block,
        ]);
    }

    public function previewAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::CREATE);
        /** @var BlockInterface $block */
        $block = $this->newResourceFactory->create($configuration, $this->factory);
        $form = $this->resourceFormFactory->create($configuration, $block);

        $form->handleRequest($request);

        /** @var BlockInterface $block */
        $block = $form->getData();

        if (!$configuration->isHtmlRequest()) {
            Assert::true(null !== $this->viewHandler);

            return $this->viewHandler->handle($configuration, View::create($block));
        }

        /** @var ContentElementRendererStrategyInterface $contentElementRendererStrategy */
        $contentElementRendererStrategy = $this->get('sylius_cms.content_element_renderer_strategy');

        return $this->render($configuration->getTemplate(ResourceActions::CREATE . '.html'), [
            'resource' => $block,
            'template' => $block->getTemplate(),
            'content' => $contentElementRendererStrategy->render($block),
            $this->metadata->getName() => $block,
        ]);
    }
}
