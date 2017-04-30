# Sylius Plugin Skeleton [![License](https://img.shields.io/packagist/l/sylius/plugin-skeleton.svg)](https://packagist.org/packages/sylius/plugin-skeleton) [![Version](https://img.shields.io/packagist/v/sylius/plugin-skeleton.svg)](https://packagist.org/packages/sylius/plugin-skeleton) [![Build status on Linux](https://img.shields.io/travis/Sylius/BundleSkeleton/master.svg)](http://travis-ci.org/Sylius/BundleSkeleton) [![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/Sylius/BundleSkeleton.svg)](https://scrutinizer-ci.com/g/Sylius/BundleSkeleton/)

## Usage

1. Run `composer create-project sylius/plugin-skeleton -s dev ProjectName`.

## Testing

In order to run Behat suites, execute following commands:

```bash
$ composer install
$ tests/Application/bin/console doctrine:database:create --env test
$ tests/Application/bin/console doctrine:schema:create --env test
$ vendor/bin/behat
```
