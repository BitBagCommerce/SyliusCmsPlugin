<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\DependencyInjection\Compiler;

use Sylius\CmsPlugin\Importer\ImporterInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ImporterCompilerPass implements CompilerPassInterface
{
    private const TAG_ID = 'sylius_cms.importer';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('sylius_cms.importer.chain')) {
            return;
        }

        $container
            ->registerForAutoconfiguration(ImporterInterface::class)
            ->addTag(self::TAG_ID)
        ;

        $taggedServices = $container->findTaggedServiceIds(self::TAG_ID);
        $definition = $container->findDefinition('sylius_cms.importer.chain');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addImporter', [new Reference($id)]);
        }
    }
}
