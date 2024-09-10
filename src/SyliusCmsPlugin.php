<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Sylius\CmsPlugin\DependencyInjection\Compiler\ContentElementPass;
use Sylius\CmsPlugin\DependencyInjection\Compiler\ImporterCompilerPass;
use Sylius\CmsPlugin\DependencyInjection\Compiler\MediaProviderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusCmsPlugin extends Bundle
{
    use SyliusPluginTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new ImporterCompilerPass());
        $container->addCompilerPass(new MediaProviderPass());
        $container->addCompilerPass(new ContentElementPass());
    }
}
