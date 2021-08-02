<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\EventListener;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class ResourceDeleteSubscriber implements EventSubscriberInterface
{
    /** @var UrlGeneratorInterface */
    private $router;

    /** @var SessionInterface */
    private $session;

    public function __construct(UrlGeneratorInterface $router, SessionInterface $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onResourceDelete',
        ];
    }

    public function onResourceDelete(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if (!$exception instanceof ForeignKeyConstraintViolationException) {
            return;
        }

        if (!$event->isMasterRequest() || 'html' !== $event->getRequest()->getRequestFormat()) {
            return;
        }

        $eventRequest = $event->getRequest();
        $requestAttributes = $eventRequest->attributes;
        $originalRoute = $requestAttributes->get('_route');

        if (!$this->isMethodDelete($eventRequest) ||
            !$this->isBitBagRoute($originalRoute) ||
            !$this->isAdminSection($requestAttributes->get('_sylius', []))
        ) {
            return;
        }

        $resourceName = $this->getResourceNameFromRoute($originalRoute);

        if (null === $requestAttributes->get('_controller')) {
            return;
        }

        /** @var FlashBagInterface $flashBag */
        $flashBag = $this->session->getBag('flashes');
        $flashBag->add('error', [
            'message' => 'sylius.resource.delete_error',
            'parameters' => ['%resource%' => $resourceName],
        ]);

        $referrer = $eventRequest->headers->get('referer');
        if (null !== $referrer) {
            $event->setResponse(new RedirectResponse($referrer));

            return;
        }

        $event->setResponse($this->createRedirectResponse($originalRoute, ResourceActions::INDEX));
    }

    private function getResourceNameFromRoute(string $route): string
    {
        $route = str_replace('_bulk', '', $route);
        $routeArray = explode('_', $route);
        $routeArrayWithoutAction = array_slice($routeArray, 0, count($routeArray) - 1);
        $routeArrayWithoutPrefixes = array_slice($routeArrayWithoutAction, 2);

        return trim(implode(' ', $routeArrayWithoutPrefixes));
    }

    private function createRedirectResponse(string $originalRoute, string $targetAction): RedirectResponse
    {
        $redirectRoute = str_replace(ResourceActions::DELETE, $targetAction, $originalRoute);

        return new RedirectResponse($this->router->generate($redirectRoute));
    }

    private function isMethodDelete(Request $request): bool
    {
        return Request::METHOD_DELETE === $request->getMethod();
    }

    private function isBitBagRoute(string $route): bool
    {
        return 0 === strpos($route, 'bitbag');
    }

    private function isAdminSection(array $syliusParameters): bool
    {
        return array_key_exists('section', $syliusParameters) && 'admin' === $syliusParameters['section'];
    }
}
