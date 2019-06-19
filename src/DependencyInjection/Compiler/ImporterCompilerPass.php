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

use BitBag\SyliusCmsPlugin\Importer\ImporterInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ImporterCompilerPass implements CompilerPassInterface
{
    private const TAG_ID = 'bitbag.cmsplugin.importer';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('bitbag_sylius_cms_plugin.importer.chain')) {
            return;
        }

        $container
            ->registerForAutoconfiguration(ImporterInterface::class)
            ->addTag(self::TAG_ID)
        ;

        $taggedServices = $container->findTaggedServiceIds(self::TAG_ID);
        $definition = $container->findDefinition('bitbag_sylius_cms_plugin.importer.chain');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addImporter', [new Reference($id)]);
        }
    }
}
