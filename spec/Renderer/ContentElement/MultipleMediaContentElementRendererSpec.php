<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\ContentElement;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\MultipleMediaContentElementType;
use Sylius\CmsPlugin\Renderer\ContentElement\AbstractContentElement;
use Sylius\CmsPlugin\Renderer\ContentElement\MultipleMediaContentElementRenderer;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Sylius\CmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use Twig\Environment;

final class MultipleMediaContentElementRendererSpec extends ObjectBehavior
{
    public function let(
        RenderMediaRuntimeInterface $renderMediaRuntime,
        MediaRepositoryInterface $mediaRepository,
    ): void {
        $this->beConstructedWith($renderMediaRuntime, $mediaRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MultipleMediaContentElementRenderer::class);
        $this->shouldBeAnInstanceOf(AbstractContentElement::class);
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
        $template = 'custom_template';
        $this->setTemplate($template);
        $this->setTwigEnvironment($twig);

        $contentConfiguration->getConfiguration()->willReturn([
            'multiple_media' => ['code1', 'code2'],
        ]);

        $mediaRepository->findBy(['code' => ['code1', 'code2']])->willReturn([$media1, $media2]);

        $media1->getCode()->willReturn('code1');
        $media2->getCode()->willReturn('code2');

        $renderMediaRuntime->renderMedia('code1')->willReturn('rendered media 1');
        $renderMediaRuntime->renderMedia('code2')->willReturn('rendered media 2');

        $twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $template,
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
