<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class BlockController extends ResourceController
{
    public const BLOCK_TEMPLATE = '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig';

    public function renderBlockAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');
        $blockResourceResolver = $this->get('bitbag_sylius_cms_plugin.resolver.block_resource');
        $block = $blockResourceResolver->findOrLog($code);

        if (null === $block) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $block);

        if (!$configuration->isHtmlRequest()) {
            return $this->viewHandler->handle($configuration, View::create($block));
        }

        $template = $request->get('template') ?? self::BLOCK_TEMPLATE;

        return $this->render($template, [
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
        $defaultLocale = $this->getParameter('locale');

        $block->setFallbackLocale($request->get('_locale', $defaultLocale));
        $block->setCurrentLocale($request->get('_locale', $defaultLocale));

        if (!$configuration->isHtmlRequest()) {
            return $this->viewHandler->handle($configuration, View::create($block));
        }

        return $this->render($configuration->getTemplate(ResourceActions::CREATE . '.html'), [
            'resource' => $block,
            $this->metadata->getName() => $block,
            'blockTemplate' => self::BLOCK_TEMPLATE,
        ]);
    }
}
