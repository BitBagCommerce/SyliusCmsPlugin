![BitBag](https://bitbag.pl/static/bitbag-logo.png)

# BitBag CmsPlugin [![Build Status](https://travis-ci.org/bitbag-commerce/CmsPlugin.svg?branch=master)](https://travis-ci.org/bitbag-commerce/CmsPlugin)

## Overview

Many of Sylius community folks asked about the right CMS plugin for their Sylius instances.  Because the original Lakion CMS plugin does not work as expected, it uses deprecated bundles and in general is not finished and EZ Platform is often too much for basic CMS usage, we decided to start the development of CMS plugin from scratch. 
So far it supports dynamic images and text blocks as well as pages with custom content. 
This plugin was developed with BDD rules in mind, so it's probably the most stable CMS for Sylius available for now. 
It is still a little bit basic, but we are planning to make it more advanced in incoming future. Contributors, ideas as well as any feedback warmly welcomed!

## Installation
```bash
$ composer require bitbag/cms-plugin
$ bin/console doctrine:schema:update --force
$ bin/console assets:install
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
    
    - { resource: '@BitBagCmsPlugin/Resources/config/config.yml' }
```

Import routing in your `app/config/routing.yml` file:

```yaml

# app/config/routing.yml
...

bitbag_cms_plugin:
    resource: '@BitBagCmsPlugin/Resources/config/routing.yml'
```

## Usage

### Blocks

In the admin panel, you can now create image and text blocks. Both can be rendered in your twig templates using `bitbag_render_block([block_code])` helper extension.
For instance, let's assume you have created a block with `homepage_text_block` code and want it to be rendered on store homepage.
In your `app/Resources/views/SyliusShopBundle/Homepage/index.html.twig` file add the twig filter like this:

```twig
{% extends '@SyliusShop/layout.html.twig' %}

{% block content %}
<h2 class="ui horizontal section divider header">
    {{ 'sylius.ui.latest_products'|trans }}
</h2>

{{ bitbag_render_block(`homepage_text_block`) }}

{{ render(url('sylius_shop_partial_product_index_latest', {'count': 4, 'template': '@SyliusShop/Product/_horizontalList.html.twig'})) }}
{% endblock %}
```

### Pages

For rendering pages you can use `bitbag_cms_shop_page_show` route which takes the `slug` as a parameter. You can also override the page template. 
For more information about how to do it, read http://docs.sylius.org/en/latest/customization/template.html. If you are lazy guy, take a look at 
`vendor/bitbag/cms-plugin/src/Resources/views/Page/show.html.twig` template, create `show.html.twig` file in `app/Resources/BitBagCmsPlugin/views` directory and paste 
 the vendor's `show.html.twig` file content to it. 
 Now you can do whatever you want with it :)
 
 There's also a twig method which allows rendering the link template for the page by its code named `bitbag_render_page_link_by_code` which obviously takes the code as a parameter.

### WYSIWYG Editor (CKEditor or any other which supports Symfony)

For now you can install CKEditor, create proper form extension and replace `Textarea[Text]Type::class` with `CKEditorType::class`.
For more - take a look at CKEditor installation manual http://symfony.com/doc/master/bundles/IvoryCKEditorBundle/installation.html,
FormExtension - https://www.google.pl/search?q=form+extension+symfony&oq=form+extension+symfony&aqs=chrome..69i57j69i60j69i65j69i61j69i60l2.2627j0j7&sourceid=chrome&ie=UTF-8
and run bin/console debug:container | grep bitbag.cms_plugin.form command to see which form services you need to extend.
Can be done within an hour and it works for us in another project 🙂

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
