<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class MediaProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('sylius_cms_plugin.registry.media_provider')) {
            return;
        }

        $providerRegistry = $container->getDefinition('sylius_cms_plugin.registry.media_provider');
        $providers = [];

        foreach ($container->findTaggedServiceIds('sylius_cms_plugin.media_provider') as $id => $attributes) {
            if (!isset($attributes[0]['type'], $attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged media provider needs to have `type` and `label` attribute.');
            }

            $name = $attributes[0]['label'];
            $type = $attributes[0]['type'];

            $providers[$name] = $type;

            $providerRegistry->addMethodCall('register', [$type, new Reference($id)]);
        }

        ksort($providers);

        $container->setParameter('sylius_cms_plugin.media_providers', $providers);
    }
}
