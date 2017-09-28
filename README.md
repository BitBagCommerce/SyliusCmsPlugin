<p align="center">
    <a href="http://sylius.org" target="_blank">
        <img src="http://demo.sylius.org/assets/shop/img/logo.png" />
    </a>
</p>
<h1 align="center">Plugin Skeleton</h1>
<p align="center">
    <a href="https://packagist.org/packages/sylius/plugin-skeleton" title="License">
        <img src="https://img.shields.io/packagist/l/sylius/plugin-skeleton.svg" />
    </a>
    <a href="https://packagist.org/packages/sylius/plugin-skeleton" title="Version">
        <img src="https://img.shields.io/packagist/v/sylius/plugin-skeleton.svg" />
    </a>
    <a href="http://travis-ci.org/Sylius/PluginSkeleton" title="Build status">
        <img src="https://img.shields.io/travis/Sylius/PluginSkeleton/master.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/Sylius/PluginSkeleton/" title="Scrutinizer">
        <img src="https://img.shields.io/scrutinizer/g/Sylius/PluginSkeleton.svg" />
    </a>
</p>

## Installation

1. Run `composer create-project sylius/plugin-skeleton ProjectName`.

2. From the plugin skeleton root directory, run the following commands:

    ```bash
    $ (cd tests/Application && yarn install)
    $ (cd tests/Application && yarn run gulp)
    $ (cd tests/Application && bin/console assets:install web -e test)
    
    $ (cd tests/Application && bin/console doctrine:database:create -e test)
    $ (cd tests/Application && bin/console doctrine:schema:create -e test)
    ```

## Usage

### Running plugin tests

  - PHPUnit

    ```bash
    $ bin/phpunit
    ```

  - PHPSpec

    ```bash
    $ bin/phpspec run
    ```

  - Behat (non-JS scenarios)

    ```bash
    $ bin/behat --tags="~@javascript"
    ```

  - Behat (JS scenarios)
 
    1. Download [Chromedriver](https://sites.google.com/a/chromium.org/chromedriver/)
    
    2. Run Selenium server with previously downloaded Chromedriver:
    
        ```bash
        $ bin/selenium-server-standalone -Dwebdriver.chrome.driver=chromedriver
        ```
    3. Run test application's webserver on `localhost:8080`:
    
        ```bash
        $ (cd tests/Application && bin/console server:run 127.0.0.1:8080 -d web -e test)
        ```
    
    4. Run Behat:
    
        ```bash
        $ bin/behat --tags="@javascript"
        ```

### Opening Sylius with your plugin

- Using `test` environment:

    ```bash
    $ (cd tests/Application && bin/console sylius:fixtures:load -e test)
    $ (cd tests/Application && bin/console server:run -d web -e test)
    ```
    
- Using `dev` environment:

    ```bash
    $ (cd tests/Application && bin/console sylius:fixtures:load -e dev)
    $ (cd tests/Application && bin/console server:run -d web -e dev)
    ```
