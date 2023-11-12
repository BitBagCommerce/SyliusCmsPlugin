<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class AuthenticationManagerPolyfillPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (
            false === $container->has('security.authentication_manager') &&
            true === $container->has('security.authentication.manager')
        ) {
            $container->setAlias('security.authentication_manager', 'security.authentication.manager');
        }
    }
}
