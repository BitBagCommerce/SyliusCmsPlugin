<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Renderer\ContentElement;

use BitBag\SyliusCmsPlugin\Entity\ContentConfigurationInterface;
use BitBag\SyliusCmsPlugin\Form\Type\ContentElements\MultipleMediaContentElementType;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\MultipleMediaContentElementRenderer;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use PhpSpec\ObjectBehavior;
use Twig\Environment;

final class MultipleMediaContentElementRendererSpec extends ObjectBehavior
{
    public function let(Environment $twig, RenderMediaRuntimeInterface $renderMediaRuntime): void
    {
        $this->beConstructedWith($twig, $renderMediaRuntime);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MultipleMediaContentElementRenderer::class);
    }

    public function it_implements_content_element_renderer_interface(): void
    {
        $this->shouldImplement(ContentElementRendererInterface::class);
    }

    public function it_supports_multiple_media_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(MultipleMediaContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_multiple_media_content_element(
        Environment $twig,
        RenderMediaRuntimeInterface $renderMediaRuntime,
        ContentConfigurationInterface $contentConfiguration
    ): void
    {
        $contentConfiguration->getConfiguration()->willReturn([
            'multiple_media' => ['media1', 'media2']
        ]);

        $renderMediaRuntime->renderMedia('media1')->willReturn('rendered media1');
        $renderMediaRuntime->renderMedia('media2')->willReturn('rendered media2');

        $twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_multiple_media.html.twig',
            'media' => ['rendered media1', 'rendered media2'],
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
