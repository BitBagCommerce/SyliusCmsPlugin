<?php

declare(strict_types=1);

use Sylius\Bundle\CoreBundle\Application\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

final class AppKernel extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles(): array
    {
        return array_merge(parent::registerBundles(), [
            new \Sylius\Bundle\AdminBundle\SyliusAdminBundle(),
            new \Sylius\Bundle\ShopBundle\SyliusShopBundle(),

            new \FOS\OAuthServerBundle\FOSOAuthServerBundle(), // Required by SyliusApiBundle
            new \Sylius\Bundle\AdminApiBundle\SyliusAdminApiBundle(),

            new \Acme\SyliusExamplePlugin\AcmeSyliusExamplePlugin(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir(): string
    {
        return sprintf('%s/%s/cache', sys_get_temp_dir(), md5(__DIR__));
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir(): string
    {
        return sprintf('%s/%s/logs', sys_get_temp_dir(), md5(__DIR__));
    }
}
