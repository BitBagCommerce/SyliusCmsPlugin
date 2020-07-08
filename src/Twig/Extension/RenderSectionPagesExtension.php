<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Twig\Extension\AbstractExtension;

final class RenderSectionPagesExtension extends AbstractExtension
{
    /** @var PageRepositoryInterface */
    private $pageRepository;

    /** @var SectionRepositoryInterface */
    private $sectionRepository;

    /** @var ChannelContextInterface */
    private $channelContext;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var EngineInterface */
    private $templatingEngine;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        SectionRepositoryInterface $sectionRepository,
        ChannelContextInterface $channelContext,
        LocaleContextInterface $localeContext,
        EngineInterface $templatingEngine
    ) {
        $this->pageRepository = $pageRepository;
        $this->sectionRepository = $sectionRepository;
        $this->channelContext = $channelContext;
        $this->localeContext = $localeContext;
        $this->templatingEngine = $templatingEngine;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_Function('bitbag_cms_render_section_pages', [$this, 'renderSectionPages'], ['is_safe' => ['html']]),
        ];
    }

    public function renderSectionPages(string $sectionCode, ?string $template = null): string
    {
        $channelCode = $this->channelContext->getChannel()->getCode();
        $section = $this->sectionRepository->findOneByCode($sectionCode, $this->localeContext->getLocaleCode());
        $pages = $this->pageRepository->createShopListQueryBuilder($sectionCode, $channelCode)->getQuery()->getResult();

        return $this->templatingEngine->render($template ?? '@BitBagSyliusCmsPlugin/Shop/Section/_pagesBySection.html.twig', [
            'section' => $section,
            'pages' => $pages,
        ]);
    }
}
