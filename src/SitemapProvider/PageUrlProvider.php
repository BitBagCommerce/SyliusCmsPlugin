<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\SitemapProvider;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Doctrine\Common\Collections\Collection;
use SitemapPlugin\Factory\UrlFactoryInterface;
use SitemapPlugin\Model\AlternativeUrl;
use SitemapPlugin\Model\ChangeFrequency;
use SitemapPlugin\Model\UrlInterface;
use SitemapPlugin\Provider\UrlProviderInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\Routing\RouterInterface;

final class PageUrlProvider implements UrlProviderInterface
{
    public function __construct(
        private PageRepositoryInterface $pageRepository,
        private RouterInterface $router,
        private UrlFactoryInterface $sitemapUrlFactory,
        private LocaleContextInterface $localeContext,
        private ChannelContextInterface $channelContext,
        ) {
    }

    public function getName(): string
    {
        return 'cms_pages';
    }

    public function generate(ChannelInterface $channel): iterable
    {
        $urls = [];

        foreach ($this->getPages() as $page) {
            $urls[] = $this->createPageUrl($page);
        }

        return $urls;
    }

    private function getTranslations(PageInterface $page): Collection
    {
        return $page->getTranslations()->filter(function (TranslationInterface $translation) {
            return $this->localeInLocaleCodes($translation);
        });
    }

    private function localeInLocaleCodes(TranslationInterface $translation): bool
    {
        return in_array($translation->getLocale(), $this->getLocaleCodes());
    }

    private function getPages(): iterable
    {
        return $this->pageRepository->findEnabled(true);
    }

    private function getLocaleCodes(): array
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();

        return $channel->getLocales()->map(function (LocaleInterface $locale) {
            return $locale->getCode();
        })->toArray();
    }

    private function createPageUrl(PageInterface $page): UrlInterface
    {
        $location = $this->router->generate('bitbag_sylius_cms_plugin_shop_page_show', [
            'slug' => $page->getTranslation($this->localeContext->getLocaleCode())->getSlug(),
            '_locale' => $this->localeContext->getLocaleCode(),
        ]);

        $pageUrl = $this->sitemapUrlFactory->createNew($location);

        $pageUrl->setChangeFrequency(ChangeFrequency::daily());
        $pageUrl->setPriority(0.7);

        if ($page->getUpdatedAt()) {
            $pageUrl->setLastModification($page->getUpdatedAt());
        } elseif ($page->getCreatedAt()) {
            $pageUrl->setLastModification($page->getCreatedAt());
        }

        /** @var PageTranslationInterface $translation */
        foreach ($this->getTranslations($page) as $translation) {
            if (!$translation->getLocale() || !$this->localeInLocaleCodes($translation) || $translation->getLocale() === $this->localeContext->getLocaleCode()) {
                continue;
            }

            $location = $this->router->generate('bitbag_sylius_cms_plugin_shop_page_show', [
                'slug' => $translation->getSlug(),
                '_locale' => $translation->getLocale(),
            ]);

            $pageUrl->addAlternative(new AlternativeUrl($location, $translation->getLocale()));
        }

        return $pageUrl;
    }
}
