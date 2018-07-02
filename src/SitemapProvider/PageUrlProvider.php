<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\SitemapProvider;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Doctrine\Common\Collections\Collection;
use SitemapPlugin\Factory\SitemapUrlFactoryInterface;
use SitemapPlugin\Model\ChangeFrequency;
use SitemapPlugin\Model\SitemapUrlInterface;
use SitemapPlugin\Provider\UrlProviderInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\Routing\RouterInterface;

class PageUrlProvider implements UrlProviderInterface
{
    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var RouterInterface */
    private $router;

    /** @var SitemapUrlFactoryInterface */
    private $sitemapUrlFactory;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var array */
    private $urls = [];

    /** @var */
    private $channelLocaleCodes;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        RouterInterface $router,
        SitemapUrlFactoryInterface $sitemapUrlFactory,
        LocaleContextInterface $localeContext,
        ChannelContextInterface $channelContext
    ) {
        $this->pageRepository = $pageRepository;
        $this->router = $router;
        $this->sitemapUrlFactory = $sitemapUrlFactory;
        $this->localeContext = $localeContext;
        $this->channelContext = $channelContext;
    }

    public function getName(): string
    {
        return 'cms_pages';
    }

    public function generate(): iterable
    {
        foreach ($this->getPages() as $product) {
            $this->urls[] = $this->createPageUrl($product);
        }

        return $this->urls;
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
        return $this->pageRepository->findByEnabled(true);
    }

    private function getLocaleCodes(): array
    {
        if (null === $this->channelLocaleCodes) {
            /** @var ChannelInterface $channel */
            $channel = $this->channelContext->getChannel();

            $this->channelLocaleCodes = $channel->getLocales()->map(function (LocaleInterface $locale) {
                return $locale->getCode();
            })->toArray();
        }

        return $this->channelLocaleCodes;
    }

    private function createPageUrl(PageInterface $page): SitemapUrlInterface
    {
        $pageUrl = $this->sitemapUrlFactory->createNew();

        $pageUrl->setChangeFrequency(ChangeFrequency::daily());
        $pageUrl->setPriority(0.7);

        if ($page->getUpdatedAt()) {
            $pageUrl->setLastModification($page->getUpdatedAt());
        } elseif ($page->getCreatedAt()) {
            $pageUrl->setLastModification($page->getCreatedAt());
        }

        /** @var PageTranslationInterface $translation */
        foreach ($this->getTranslations($page) as $translation) {
            if (!$translation->getLocale()) {
                continue;
            }

            if (!$this->localeInLocaleCodes($translation)) {
                continue;
            }

            $location = $this->router->generate('bitbag_sylius_cms_plugin_shop_page_show', [
                'slug' => $translation->getSlug(),
                '_locale' => $translation->getLocale(),
            ]);

            if ($translation->getLocale() === $this->localeContext->getLocaleCode()) {
                $pageUrl->setLocalization($location);

                continue;
            }

            $pageUrl->addAlternative($location, $translation->getLocale());
        }

        return $pageUrl;
    }
}
