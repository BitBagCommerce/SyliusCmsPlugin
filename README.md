<p align="center">
    <a href="http://sylius.org" target="_blank">
        <img src="http://demo.sylius.org/assets/shop/img/logo.png" />
    </a>
</p>
<h1 align="center">Plugin Skeleton</h1>
<p align="center">
    <a href="https://packagist.org/packages/sylius/plugin-skeleton">
        <img src="https://img.shields.io/packagist/l/sylius/plugin-skeleton.svg" alt="License" />
    </a>
    <a href="https://packagist.org/packages/sylius/plugin-skeleton">
        <img src="https://img.shields.io/packagist/v/sylius/plugin-skeleton.svg" alt="Version" />
    </a>
    <a href="http://travis-ci.org/Sylius/PluginSkeleton">
        <img src="https://img.shields.io/travis/Sylius/PluginSkeleton/master.svg" alt="Build status" />
    </a>
    <a href="https://scrutinizer-ci.com/g/Sylius/PluginSkeleton/">
        <img src="https://img.shields.io/scrutinizer/g/Sylius/PluginSkeleton.svg" alt="Scrutinizer" />
    </a>
</p>

## Installation

1. Run `composer create-project sylius/plugin-skeleton -s dev ProjectName`.

2. From the plugin skeleton root directory, run the following commands:

    ```bash
    $ composer install
    
    $ (cd tests/Application && yarn install)
    $ (cd tests/Application && yarn run gulp)
    
    $ (cd tests/Application && bin/console doctrine:database:create -e test)
    $ (cd tests/Application && bin/console doctrine:schema:create -e test)
    ```

## Usage

### Running plugin tests

```bash
$ vendor/bin/behat
$ vendor/bin/phpunit
$ vendor/bin/phpspec
```

### Opening Sylius with your plugin

- Using `test` environment:

    ```bash
    $ (cd tests/Application && bin/console server:run -d web -e test)
    ```
    
- Using `dev` environment

    ```bash
    $ (cd tests/Application && bin/console server:run -d web -e dev)
    ```
