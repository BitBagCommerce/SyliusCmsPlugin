<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaProviderResolverInterface;
use BitBag\SyliusCmsPlugin\Resolver\MediaResourceResolverInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Webmozart\Assert\Assert;

final class MediaController extends ResourceController
{
    use ResourceDataProcessingTrait;
    use MediaPageControllersCommonDependencyInjectionsTrait;

    /** @var MediaResourceResolverInterface */
    private $mediaResourceResolver;

    /** @var MediaProviderResolverInterface */
    private $mediaProviderResolver;

    public const FILTER = 'sylius_admin_product_original';

    public function renderMediaAction(Request $request): Response
    {
        $configuration = $this->getRequestConfiguration($request);
        /** @var MediaInterface|null $media */
        $media = $this->getMediaForRequestCode($configuration, $request);

        if (null === $media) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $media);

        return new Response($this->mediaProviderResolver->resolveProvider($media)->render($media, $request->get('template')));
    }

    public function downloadMediaAction(Request $request): Response
    {
        $configuration = $this->getRequestConfiguration($request);

        /** @var MediaInterface|null $media */
        $media = $this->getMediaForRequestCode($configuration, $request);
        Assert::notNull($media);
        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $media);
        $mediaPath = $this->getMediaPathIfNotNull($media);
        $mediaFile = new File($mediaPath);
        $mediaName = $media->getDownloadName() . '.' . $mediaFile->guessExtension();
        $response = new BinaryFileResponse($mediaPath);

        $response->setContentDisposition(
            $request->get('disposition', ResponseHeaderBag::DISPOSITION_ATTACHMENT),
            $mediaName,
        );
        $response->headers->set('Content-Type', $media->getMimeType());

        return $response;
    }

    public function previewAction(Request $request): Response
    {
        $configuration = $this->getRequestConfiguration($request);

        $this->isGrantedOr403($configuration, ResourceActions::CREATE);
        /** @var MediaInterface $media */
        $media = $this->getResourceInterface($request);
        $form = $this->getFormForResource($configuration, $media);
        $mediaTemplate = null;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->setMediaLocales($media, $request);
            $this->setMediaPathIfExists($media);
            $mediaTemplate = $this->mediaProviderResolver->resolveProvider($media)->getTemplate();
        }
        $this->formErrorsFlashHelper->addFlashErrors($form);

        return $this->render($configuration->getTemplate(ResourceActions::CREATE . '.html'), [
            'metadata' => $this->metadata,
            'resource' => $media,
            'mediaTemplate' => $mediaTemplate,
            $this->metadata->getName() => $media,
        ]);
    }

    public function setMediaProviderResolver(MediaProviderResolverInterface $mediaProviderResolver): void
    {
        $this->mediaProviderResolver = $mediaProviderResolver;
    }

    public function setMediaResourceResolver(MediaResourceResolverInterface $mediaResourceResolver): void
    {
        $this->mediaResourceResolver = $mediaResourceResolver;
    }

    private function getMediaForRequestCode(RequestConfiguration $configuration, Request $request): ?MediaInterface
    {
        $this->isGrantedOr403($configuration, ResourceActions::SHOW);
        $code = $request->get('code');

        return $this->mediaResourceResolver->findOrLog($code);
    }

    private function setMediaLocales(MediaInterface $media, Request $request): void
    {
        $defaultLocale = $this->getParameter('locale');
        $media->setFallbackLocale($request->get('_locale', $defaultLocale));
        $media->setCurrentLocale($request->get('_locale', $defaultLocale));
    }

    private function setMediaPathIfExists(MediaInterface $media): void
    {
        if (null !== $media->getFile() || null !== $media->getPath()) {
            $this->setResourceMediaPath($media);
        }
    }
}
