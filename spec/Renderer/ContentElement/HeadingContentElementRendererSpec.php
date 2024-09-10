<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\ContentElement;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\HeadingContentElementType;
use Sylius\CmsPlugin\Renderer\ContentElement\AbstractContentElement;
use Sylius\CmsPlugin\Renderer\ContentElement\HeadingContentElementRenderer;
use Twig\Environment;

final class HeadingContentElementRendererSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(HeadingContentElementRenderer::class);
        $this->shouldBeAnInstanceOf(AbstractContentElement::class);
    }

    public function it_supports_heading_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(HeadingContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_heading_content_element(Environment $twig, ContentConfigurationInterface $contentConfiguration): void
    {
        $template = 'custom_template';
        $this->setTemplate($template);
        $this->setTwigEnvironment($twig);

        $contentConfiguration->getConfiguration()->willReturn([
            'heading_type' => 'h1',
            'heading' => 'Sample Heading',
        ]);

        $twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $template,
            'heading_type' => 'h1',
            'heading_content' => 'Sample Heading',
        ])->willReturn('rendered template');

        $this->render($contentConfiguration)->shouldReturn('rendered template');
    }
}
