# Sylius Plugin Skeleton [![License](https://img.shields.io/packagist/l/sylius/plugin-skeleton.svg)](https://packagist.org/packages/sylius/plugin-skeleton) [![Version](https://img.shields.io/packagist/v/sylius/plugin-skeleton.svg)](https://packagist.org/packages/sylius/plugin-skeleton) [![Build status on Linux](https://img.shields.io/travis/Sylius/PluginSkeleton/master.svg)](http://travis-ci.org/Sylius/PluginSkeleton) [![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/Sylius/eSkeleton.svg)](https://scrutinizer-ci.com/g/Sylius/PluginSkeleton/)

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
