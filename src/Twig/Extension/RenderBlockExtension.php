<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Twig\Extension;

use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use BitBag\SyliusCmsPlugin\Resolver\BlockResourceResolverInterface;
use Symfony\Component\Templating\EngineInterface;

final class RenderBlockExtension extends \Twig_Extension
{
    /** @var BlockRepositoryInterface */
    private $blockRepository;

    /** @var BlockResourceResolverInterface */
    private $blockResourceResolver;

    /** @var EngineInterface */
    private $templatingEngine;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockResourceResolverInterface $blockResourceResolver,
        EngineInterface $templatingEngine
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockResourceResolver = $blockResourceResolver;
        $this->templatingEngine = $templatingEngine;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_Function('bitbag_cms_render_block', [$this, 'renderBlock'], ['is_safe' => ['html']]),
        ];
    }

    public function renderBlock(string $code, ?string $template = null): string
    {
        $block = $this->blockResourceResolver->findOrLog($code);

        if (null !== $block) {
            $template = $template ?? '@BitBagSyliusCmsPlugin/Shop/Block/show.html.twig';

            return $this->templatingEngine->render($template, ['block' => $block]);
        }

        return '';
    }
}
