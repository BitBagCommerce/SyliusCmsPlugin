<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Resolver;

use BitBag\SyliusCmsPlugin\Entity\EventInterface;
use BitBag\SyliusCmsPlugin\Repository\EventRepositoryInterface;
use Psr\Log\LoggerInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class EventResourceResolver implements EventResourceResolverInterface
{
    /** @var EventRepositoryInterface */
    private $eventRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        LocaleContextInterface $localeContext,
        LoggerInterface $logger
    ) {
        $this->eventRepository = $eventRepository;
        $this->localeContext = $localeContext;
        $this->logger = $logger;
    }

    public function findOrLog(string $code): ?EventInterface
    {
        $event = $this->eventRepository->findOneEnabledByCode($code, $this->localeContext->getLocaleCode());

        if (false === $event instanceof EventInterface) {
            $this->logger->warning(sprintf(
                'Event with "%s" code was not found in the database.',
                $code
            ));

            return null;
        }

        return $event;
    }
}
