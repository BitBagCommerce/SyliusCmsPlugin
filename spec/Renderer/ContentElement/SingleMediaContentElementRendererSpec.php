<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\ContentElement;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\SingleMediaContentElementType;
use Sylius\CmsPlugin\Renderer\ContentElement\AbstractContentElement;
use Sylius\CmsPlugin\Renderer\ContentElement\SingleMediaContentElementRenderer;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Sylius\CmsPlugin\Twig\Runtime\RenderMediaRuntimeInterface;
use Twig\Environment;

final class SingleMediaContentElementRendererSpec extends ObjectBehavior
{
    public function let(RenderMediaRuntimeInterface $renderMediaRuntime, MediaRepositoryInterface $mediaRepository): void
    {
        $this->beConstructedWith($renderMediaRuntime, $mediaRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SingleMediaContentElementRenderer::class);
        $this->shouldBeAnInstanceOf(AbstractContentElement::class);
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
        MediaInterface $media,
    ): void {
        $template = 'custom_template';
        $this->setTemplate($template);
        $this->setTwigEnvironment($twig);

        $contentConfiguration->getConfiguration()->willReturn([
            'single_media' => 'media_code',
        ]);

        $renderMediaRuntime->renderMedia('media_code')->willReturn('rendered media');
        $mediaRepository->findOneBy(['code' => 'media_code'])->willReturn($media);

        $twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $template,
            'media' => [
                'renderedContent' => 'rendered media',
                'entity' => $media,
            ],
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
