<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Provider;

use PhpSpec\ObjectBehavior;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Sylius\CmsPlugin\Provider\ResourceTemplateProvider;
use Sylius\CmsPlugin\Provider\ResourceTemplateProviderInterface;

final class ResourceTemplateProviderSpec extends ObjectBehavior
{
    public function let(ParameterBagInterface $parameterBag): void
    {
        $parameterBag->get('sylius_cms.templates.pages')->willReturn([
            '@CustomTemplate/Page.html.twig' => '@CustomTemplate/Page.html.twig',
        ]);

        $parameterBag->get('sylius_cms.templates.blocks')->willReturn([
            '@CustomTemplate/Block.html.twig' => '@CustomTemplate/Block.html.twig',
        ]);

        $this->beConstructedWith($parameterBag);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ResourceTemplateProvider::class);
    }

    public function it_implements_resource_template_provider_interface(): void
    {
        $this->shouldImplement(ResourceTemplateProviderInterface::class);
    }

    public function it_returns_default_and_custom_page_templates(): void
    {
        $this->getPageTemplates()->shouldReturn([
            'sylius.ui.default' => '@SyliusCmsPlugin/Shop/Page/show.html.twig',
            '@CustomTemplate/Page.html.twig' => '@CustomTemplate/Page.html.twig',
        ]);
    }

    public function it_returns_default_and_custom_block_templates(): void
    {
        $this->getBlockTemplates()->shouldReturn([
            'sylius.ui.default' => '@SyliusCmsPlugin/Shop/Block/show.html.twig',
            '@CustomTemplate/Block.html.twig' => '@CustomTemplate/Block.html.twig',
        ]);
    }
}
