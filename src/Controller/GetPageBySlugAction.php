<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

use ApiPlatform\Core\Api\IriConverterInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class GetPageBySlugAction
{
    public function __construct(
        private ChannelContextInterface $channelContext,
        private LocaleContextInterface $localeContext,
        private PageRepositoryInterface $pageRepository,
        private IriConverterInterface $iriConverter,
        private RequestStack $requestStack,
    ) {
    }

    public function __invoke(string $slug): RedirectResponse
    {
        $channel = $this->channelContext->getChannel();
        $locale = $this->localeContext->getLocaleCode();

        $page = $this->pageRepository->findOneEnabledBySlugAndChannelCode($slug, $locale, $channel->getCode());

        if (null === $page) {
            throw new NotFoundHttpException('Not Found');
        }

        $iri = $this->iriConverter->getIriFromItem($page);

        $request = $this->requestStack->getCurrentRequest();

        $requestQuery = $request->getQueryString();
        if (null !== $requestQuery) {
            $iri .= sprintf('?%s', $requestQuery);
        }

        return new RedirectResponse($iri, Response::HTTP_MOVED_PERMANENTLY);
    }
}
