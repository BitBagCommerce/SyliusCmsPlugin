![BitBag](https://bitbag.pl/static/bitbag-logo.png)

# BitBag CmsPlugin [![Build Status](https://travis-ci.org/bitbag-commerce/CmsPlugin.svg?branch=master)](https://travis-ci.org/bitbag-commerce/CmsPlugin)

## Overview

Because the original Lakion CMS plugin does not work as expected, it uses deprecated bundles and in general is not finished and EZ Platform is often too much for basic CMS usage, we decided to start the development of CMS plugin from scratch. So far it supports dynamic images and text blocks but things like pages, product images, etc. still need to be developed. Contributors are warmly welcomed!

## Installation
```bash
$ composer require bitbag/cms-plugin
$ bin/console doctrine:schema:update --force
```
    
Add plugin dependencies to your AppKernel.php file:
```php
public function registerBundles()
{
    return array_merge(parent::registerBundles(), [
        ...
        
        new BitBag\CmsPlugin\BitBagCmsPlugin(),
    ]);
}
```

Import required config in your `app/config/config.yml` file:

```yaml
# app/config/config.yml

imports:
    ...
    
    - { resource: "@BitBagCmsPlugin/Resources/config/config.yml" }
```

Import routing in your `app/config/routing.yml` file:

```yaml

# app/config/routing.yml
...

bitbag_cms_plugin:
    resource: '@BitBagCmsPlugin/Resources/config/routing.yml'
```

## Usage

In the admin panel you can now create image and text blocks. Both can be rendered in your twig templates using `bitbag_render_block([block_code])` helper extension.

## Testing
```bash
$ wget http://getcomposer.org/composer.phar
$ php composer.phar install
$ yarn install
$ yarn run gulp
$ php bin/console sylius:install --env test
$ php bin/console server:start --env test
$ open http://localhost:8000
$ bin/behat features/*
$ bin/phpspec run
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.