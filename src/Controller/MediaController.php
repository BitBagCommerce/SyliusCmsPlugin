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

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

final class MediaController extends ResourceController
{
    public function renderMediaAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');
        $mediaResourceResolver = $this->get('bitbag_sylius_cms_plugin.resolver.media_resource');
        $media = $mediaResourceResolver->findOrLog($code);

        if (null === $media) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $media);

        $mediaProviderResolver = $this->get('bitbag_sylius_cms_plugin.resolver.media_provider');

        return new Response($mediaProviderResolver->resolveProvider($media)->render($media));
    }

    public function downloadMediaAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');
        $mediaResourceResolver = $this->get('bitbag_sylius_cms_plugin.resolver.media_resource');
        /** @var MediaInterface $media */
        $media = $mediaResourceResolver->findOrLog($code);

        if (null === $media) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $media);

        $response = new BinaryFileResponse($media->getOriginalPath());

        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        $response->headers->set('Content-Type', $media->getMimeType());

        return $response;
    }
}
