<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class MediaProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('bitbag_sylius_cms_plugin.registry.media_provider')) {
            return;
        }

        $providerRegistry = $container->getDefinition('bitbag_sylius_cms_plugin.registry.media_provider');
        $providers = [];

        foreach ($container->findTaggedServiceIds('bitbag_sylius_cms_plugin.media_provider') as $id => $attributes) {
            if (!isset($attributes[0]['type']) || !isset($attributes[0]['label'])) {
                throw new \InvalidArgumentException('Tagged media provider needs to have `type` and `label` attribute.');
            }

            $name = $attributes[0]['label'];
            $type = $attributes[0]['type'];
            
            $providers[$name] = $type;

            $providerRegistry->addMethodCall('register', [$type, new Reference($id)]);
        }

        ksort($providers);
        
        $container->setParameter('bitbag_sylius_cms_plugin.media_providers', $providers);
    }
}
