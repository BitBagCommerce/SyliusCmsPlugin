<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Provider;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class ResourceTemplateProvider implements ResourceTemplateProviderInterface
{
    private array $templates = [];

    public function __construct(ParameterBagInterface $params)
    {
        if (is_array($params->get('sylius_cms.templates.pages'))) {
            $this->templates['pages'] = $params->get('sylius_cms.templates.pages');
        }

        if (is_array($params->get('sylius_cms.templates.blocks'))) {
            $this->templates['blocks'] = $params->get('sylius_cms.templates.blocks');
        }
    }

    public function getPageTemplates(): array
    {
        $keys = ['sylius.ui.default'];
        $values = ['@SyliusCmsPlugin/Shop/Page/show.html.twig'];

        return array_combine(
            array_merge($keys, $this->templates['pages']),
            array_merge($values, $this->templates['pages']),
        );
    }

    public function getBlockTemplates(): array
    {
        $keys = ['sylius.ui.default'];
        $values = ['@SyliusCmsPlugin/Shop/Block/show.html.twig'];

        return array_combine(
            array_merge($keys, $this->templates['blocks']),
            array_merge($values, $this->templates['blocks']),
        );
    }
}
