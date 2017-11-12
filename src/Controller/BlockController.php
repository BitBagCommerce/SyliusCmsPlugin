<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Controller;

use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class BlockController extends ResourceController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function renderBlockAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');
        $blockResourceResolver = $this->get('bitbag.resolver.block_resource');

        $block = $blockResourceResolver->findOrLog($code);

        if (null === $block) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $block);

        $view = View::create($block);
        $blockTemplateResolver = $this->get('bitbag.resolver.block_template');
        $template = $blockTemplateResolver->resolveTemplate($block);

        if ($configuration->isHtmlRequest()) {
            $view
                ->setTemplate($template)
                ->setTemplateVar($this->metadata->getName())
                ->setData([
                    'configuration' => $configuration,
                    'metadata' => $this->metadata,
                    'resource' => $block,
                    $this->metadata->getName() => $block,
                ])
            ;
        }

        return $this->viewHandler->handle($configuration, $view);
    }
}
