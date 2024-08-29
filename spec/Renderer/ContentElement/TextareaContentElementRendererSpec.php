<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\ContentElement;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\TextareaContentElementType;
use Sylius\CmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use Sylius\CmsPlugin\Renderer\ContentElement\TextareaContentElementRenderer;
use Twig\Environment;

final class TextareaContentElementRendererSpec extends ObjectBehavior
{
    public function let(Environment $twig): void
    {
        $this->beConstructedWith($twig);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TextareaContentElementRenderer::class);
    }

    public function it_implements_content_element_renderer_interface(): void
    {
        $this->shouldImplement(ContentElementRendererInterface::class);
    }

    public function it_supports_textarea_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(TextareaContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_textarea_content_element(
        Environment $twig,
        ContentConfigurationInterface $contentConfiguration,
    ): void {
        $contentConfiguration->getConfiguration()->willReturn([
            'textarea' => 'Textarea content',
        ]);

        $twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_textarea.html.twig',
            'content' => 'Textarea content',
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
