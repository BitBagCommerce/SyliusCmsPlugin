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

## Usage

1. Run `composer create-project sylius/plugin-skeleton -s dev ProjectName`.

## Testing & Development

In order to run tests, execute following commands:

```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn run gulp
$ bin/console doctrine:database:create --env test
$ bin/console doctrine:schema:create --env test
$ vendor/bin/behat
$ vendor/bin/phpunit
$ vendor/bin/phpspec
```

In order to open test app in your browser, do the following:

```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn run gulp
$ bin/console doctrine:database:create --env test
$ bin/console doctrine:schema:create --env test
$ bin/console server:start --env test
$ open http://127.0.0.1:8000/
```
