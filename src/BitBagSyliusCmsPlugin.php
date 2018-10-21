<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin;

use BitBag\SyliusCmsPlugin\DependencyInjection\Compiler\ImporterCompilerPass;
use BitBag\SyliusCmsPlugin\DependencyInjection\Compiler\MediaProviderPass;
use BitBag\SyliusCmsPlugin\DependencyInjection\Compiler\RemoveSyliusThemeFilesystemLoaderPass;
use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BitBagSyliusCmsPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ImporterCompilerPass());
        $container->addCompilerPass(new MediaProviderPass());
        $container->addCompilerPass(new RemoveSyliusThemeFilesystemLoaderPass());
    }
}
