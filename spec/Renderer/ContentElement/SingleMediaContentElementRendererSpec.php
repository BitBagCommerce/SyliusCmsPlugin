<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Renderer\ContentElement;

use BitBag\SyliusCmsPlugin\Entity\ContentConfigurationInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Form\Type\ContentElements\SingleMediaContentElementType;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\SingleMediaContentElementRenderer;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use PhpSpec\ObjectBehavior;
use Twig\Environment;

final class SingleMediaContentElementRendererSpec extends ObjectBehavior
{
    public function let(Environment $twig, RenderMediaRuntimeInterface $renderMediaRuntime, MediaRepositoryInterface $mediaRepository): void
    {
        $this->beConstructedWith($twig, $renderMediaRuntime, $mediaRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SingleMediaContentElementRenderer::class);
    }

    public function it_implements_content_element_renderer_interface(): void
    {
        $this->shouldImplement(ContentElementRendererInterface::class);
    }

    public function it_supports_single_media_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(SingleMediaContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_single_media_content_element(
        Environment $twig,
        RenderMediaRuntimeInterface $renderMediaRuntime,
        MediaRepositoryInterface $mediaRepository,
        ContentConfigurationInterface $contentConfiguration,
        MediaInterface $media
    ): void
    {
        $contentConfiguration->getConfiguration()->willReturn([
            'single_media' => 'media_code'
        ]);

        $renderMediaRuntime->renderMedia('media_code')->willReturn('rendered media');
        $mediaRepository->findOneBy(['code' => 'media_code'])->willReturn($media);

        $twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_single_media.html.twig',
            'media' => [
                'renderedContent' => 'rendered media',
                'entity' => $media,
            ],
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
