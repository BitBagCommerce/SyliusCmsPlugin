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
use BitBag\SyliusCmsPlugin\Form\Type\ContentElements\MultipleMediaContentElementType;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\MultipleMediaContentElementRenderer;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use PhpSpec\ObjectBehavior;
use Twig\Environment;

final class MultipleMediaContentElementRendererSpec extends ObjectBehavior
{
    public function let(
        Environment $twig,
        RenderMediaRuntimeInterface $renderMediaRuntime,
        MediaRepositoryInterface $mediaRepository,
    ): void {
        $this->beConstructedWith($twig, $renderMediaRuntime, $mediaRepository);
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
        MediaRepositoryInterface $mediaRepository,
        ContentConfigurationInterface $contentConfiguration,
        MediaInterface $media1,
        MediaInterface $media2,
    ): void {
        $contentConfiguration->getConfiguration()->willReturn([
            'multiple_media' => ['code1', 'code2'],
        ]);

        $mediaRepository->findBy(['code' => ['code1', 'code2']])->willReturn([$media1, $media2]);

        $media1->getCode()->willReturn('code1');
        $media2->getCode()->willReturn('code2');

        $renderMediaRuntime->renderMedia('code1')->willReturn('rendered media 1');
        $renderMediaRuntime->renderMedia('code2')->willReturn('rendered media 2');

        $twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_multiple_media.html.twig',
            'media' => [
                [
                    'renderedContent' => 'rendered media 1',
                    'entity' => $media1,
                ],
                [
                    'renderedContent' => 'rendered media 2',
                    'entity' => $media2,
                ],
            ],
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
