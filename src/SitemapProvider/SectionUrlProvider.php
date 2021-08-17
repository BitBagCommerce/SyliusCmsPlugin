<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\SitemapProvider;

use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
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

final class SectionUrlProvider implements UrlProviderInterface
{
    /** @var SectionRepositoryInterface */
    private $sectionRepository;

    /** @var RouterInterface */
    private $router;

    /** @var UrlFactoryInterface */
    private $sitemapUrlFactory;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ChannelContextInterface */
    private $channelContext;

    public function __construct(
        SectionRepositoryInterface $sectionRepository,
        RouterInterface $router,
        UrlFactoryInterface $sitemapUrlFactory,
        LocaleContextInterface $localeContext,
        ChannelContextInterface $channelContext
    ) {
        $this->sectionRepository = $sectionRepository;
        $this->router = $router;
        $this->sitemapUrlFactory = $sitemapUrlFactory;
        $this->localeContext = $localeContext;
        $this->channelContext = $channelContext;
    }

    public function getName(): string
    {
        return 'cms_sections';
    }

    public function generate(ChannelInterface $channel): iterable
    {
        $urls = [];

        foreach ($this->getSections() as $section) {
            $urls[] = $this->createSectionUrl($section);
        }

        return $urls;
    }

    private function getTranslations(SectionInterface $section): Collection
    {
        return $section->getTranslations()->filter(function (TranslationInterface $translation) {
            return $this->localeInLocaleCodes($translation);
        });
    }

    private function localeInLocaleCodes(TranslationInterface $translation): bool
    {
        return in_array($translation->getLocale(), $this->getLocaleCodes());
    }

    private function getSections(): iterable
    {
        return $this->sectionRepository->findAll();
    }

    private function getLocaleCodes(): array
    {
        /** @var ChannelInterface $channel */
        $channel = $this->channelContext->getChannel();

        return $channel->getLocales()->map(function (LocaleInterface $locale) {
            return $locale->getCode();
        })->toArray();
    }

    private function createSectionUrl(SectionInterface $section): UrlInterface
    {
        $location = $this->router->generate('bitbag_sylius_cms_plugin_shop_section_show', [
            'code' => $section->getCode(),
            '_locale' => $this->localeContext->getLocaleCode(),
        ]);
        $url = $this->sitemapUrlFactory->createNew($location);

        $url->setChangeFrequency(ChangeFrequency::daily());
        $url->setPriority(0.7);

        /** @var SectionTranslationInterface $translation */
        foreach ($this->getTranslations($section) as $translation) {
            if (!$translation->getLocale() || !$this->localeInLocaleCodes($translation) || $translation->getLocale() === $this->localeContext->getLocaleCode()) {
                continue;
            }

            $location = $this->router->generate('bitbag_sylius_cms_plugin_shop_section_show', [
                'code' => $section->getCode(),
                '_locale' => $translation->getLocale(),
            ]);

            $url->addAlternative(new AlternativeUrl($location, $translation->getLocale()));
        }

        return $url;
    }
}
