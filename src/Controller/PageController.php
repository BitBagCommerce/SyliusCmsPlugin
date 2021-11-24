<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\CustomResourceController;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Resolver\PageResourceResolverInterface;
use FOS\RestBundle\View\View;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PageController extends CustomResourceController
{
    /** @var PageResourceResolverInterface */
    protected $resourceResolver;

    public function renderLinkAction(Request $request): Response
    {
        $configuration = $this->getRequestConfiguration($request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');

        $page = $this->resourceResolver->findOrLog($code);

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

        assert(null !== $this->viewHandler);

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

        $this->resolveImage($page);

        $this->formErrorsFlashHelper->addFlashErrors($form);

        if (!$configuration->isHtmlRequest()) {
            assert(null !== $this->viewHandler);
            $this->viewHandler->handle($configuration, View::create($page));
        }

        return $this->render($configuration->getTemplate(ResourceActions::CREATE . '.html'), [
            'resource' => $page,
            'preview' => true,
            $this->metadata->getName() => $page,
        ]);
    }

    private function resolveImage(PageInterface $page): void
    {
        /** @var PageTranslationInterface $translation */
        $translation = $page->getTranslation();

        $image = $translation->getImage();

        if (null === $image || null === $image->getPath()) {
            return;
        }

        /** @var string|null $imagePath */
        $imagePath = $image->getPath();
        assert(null !== $imagePath && is_string($this->getParameter('sylius_core.public_dir')));
        $file = $image->getFile() ?? new File($this->getParameter('sylius_core.public_dir') . $imagePath);
        $fileContents = file_get_contents($file->getPathname());
        assert(is_string($fileContents));
        $base64Content = base64_encode($fileContents);
        $path = 'data:' . $file->getMimeType() . ';base64, ' . $base64Content;
        $image->setPath($path);
        /** @var PageTranslationInterface $pageTranslationInterface */
        $pageTranslationInterface = $page->getTranslation();
        $pageTranslationInterface->setImage($image);
    }
}
