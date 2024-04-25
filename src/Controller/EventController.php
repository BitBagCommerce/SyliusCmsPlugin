<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use BitBag\SyliusCmsPlugin\Entity\EventInterface;
use BitBag\SyliusCmsPlugin\Entity\EventTranslationInterface;
use BitBag\SyliusCmsPlugin\Resolver\EventResourceResolverInterface;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class EventController extends ResourceController
{
    use ResourceDataProcessingTrait;

    use MediaPageControllersCommonDependencyInjectionsTrait;

    /** @var EventResourceResolverInterface */
    private $eventResourceResolver;

    public const FILTER = 'sylius_admin_product_original';

    public function renderLinkAction(Request $request): Response
    {
        $configuration = $this->getRequestConfiguration($request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);

        $code = $request->get('code');

        $event = $this->eventResourceResolver->findOrLog($code);

        if (null === $event) {
            return new Response();
        }

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $event);

        if ($configuration->isHtmlRequest()) {
            return $this->render($configuration->getTemplate(ResourceActions::SHOW . '.html'), [
                'configuration' => $configuration,
                'metadata' => $this->metadata,
                'resource' => $event,
                $this->metadata->getName() => $event,
            ]);
        }

        Assert::true(null !== $this->viewHandler);

        return $this->viewHandler->handle($configuration, View::create($event));
    }

    public function previewAction(Request $request): Response
    {
        $configuration = $this->getRequestConfiguration($request);

        $this->isGrantedOr403($configuration, ResourceActions::CREATE);

        /** @var EventInterface $event */
        $event = $this->getResourceInterface($request);
        $form = $this->getFormForResource($configuration, $event);
        $defaultLocale = $this->getParameter('locale');

        $form->handleRequest($request);

        $event->setFallbackLocale($request->get('_locale', $defaultLocale));
        $event->setCurrentLocale($request->get('_locale', $defaultLocale));

        $this->resolveImage($event);

        $this->formErrorsFlashHelper->addFlashErrors($form);

        if (!$configuration->isHtmlRequest()) {
            Assert::true(null !== $this->viewHandler);
            $this->viewHandler->handle($configuration, View::create($event));
        }

        return $this->render($configuration->getTemplate(ResourceActions::CREATE . '.html'), [
            'resource' => $event,
            'preview' => true,
            $this->metadata->getName() => $event,
        ]);
    }

    private function resolveImage(EventInterface $event): void
    {
        /** @var EventTranslationInterface $translation */
        $translation = $event->getTranslation();

        $image = $translation->getImage();

        if (null === $image || null === $image->getPath()) {
            return;
        }
        $this->setResourceMediaPath($image);
        /** @var EventTranslationInterface $eventTranslationInterface */
        $eventTranslationInterface = $event->getTranslation();
        $eventTranslationInterface->setImage($image);
    }

    public function setEventResourceResolver(EventResourceResolverInterface $eventResourceResolver): void
    {
        $this->eventResourceResolver = $eventResourceResolver;
    }
}
