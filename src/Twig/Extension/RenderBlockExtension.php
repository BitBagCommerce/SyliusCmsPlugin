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
use BitBag\SyliusCmsPlugin\Resolver\BlockTemplateResolverInterface;

final class RenderBlockExtension extends \Twig_Extension
{
    /** @var BlockRepositoryInterface */
    private $blockRepository;

    /** @var BlockTemplateResolverInterface */
    private $blockTemplateResolver;

    /** @var BlockResourceResolverInterface */
    private $blockResourceResolver;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockTemplateResolverInterface $blockTemplateResolver,
        BlockResourceResolverInterface $blockResourceResolver
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockTemplateResolver = $blockTemplateResolver;
        $this->blockResourceResolver = $blockResourceResolver;
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('bitbag_cms_render_block', [$this, 'renderBlock'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function renderBlock(\Twig_Environment $twigEnvironment, string $code, ?string $template = null): string
    {
        $block = $this->blockResourceResolver->findOrLog($code);

        if (null !== $block) {
            $template = $template ?? $this->blockTemplateResolver->resolveTemplate($block);

            return $twigEnvironment->render($template, ['block' => $block]);
        }

        return '';
    }
}
