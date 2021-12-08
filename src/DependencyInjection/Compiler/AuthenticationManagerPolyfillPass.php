<?php

namespace BitBag\SyliusCmsPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AuthenticationManagerPolyfillPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (
            $container->has('security.authentication_manager') === false
            &&
            $container->has('security.authentication.manager') === true
        ) {
            $container->setAlias('security.authentication_manager', 'security.authentication.manager');
        }
    }
}
