<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\DependencyInjection\Compiler;

use Sylius\CmsPlugin\Importer\ImporterInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ImporterCompilerPass implements CompilerPassInterface
{
    private const TAG_ID = 'bitbag.cmsplugin.importer';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('sylius_cms_plugin.importer.chain')) {
            return;
        }

        $container
            ->registerForAutoconfiguration(ImporterInterface::class)
            ->addTag(self::TAG_ID)
        ;

        $taggedServices = $container->findTaggedServiceIds(self::TAG_ID);
        $definition = $container->findDefinition('sylius_cms_plugin.importer.chain');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addImporter', [new Reference($id)]);
        }
    }
}
