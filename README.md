<h1 align="center">
    <a href="http://bitbag.shop" target="_blank">
        <img src="https://raw.githubusercontent.com/bitbager/BitBagCommerceAssets/master/SyliusCmsPlugin.png" />
    </a>
    <br />
    <a href="https://packagist.org/packages/bitbag/cms-plugin" title="License" target="_blank">
        <img src="https://img.shields.io/packagist/l/bitbag/cms-plugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/cms-plugin" title="Version" target="_blank">
        <img src="https://img.shields.io/packagist/v/bitbag/cms-plugin.svg" />
    </a>
    <a href="http://travis-ci.org/BitBagCommerce/SyliusCmsPlugin" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/BitBagCommerce/SyliusCmsPlugin/master.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/BitBagCommerce/SyliusCmsPlugin/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/BitBagCommerce/SyliusCmsPlugin.svg" />
    </a>
    <a href="https://packagist.org/packages/bitbag/cms-plugin" title="Total Downloads" target="_blank">
        <img src="https://poser.pugx.org/bitbag/cms-plugin/downloads" />
    </a>
</h1>

## Overview

Almost each eCommerce app has to present some content. Managing it is often done via third-party libraries like Wordpress, eZ Platform or a built-in content management system. As Sylius does not have a CMS in the standard platform, we decided to develop our own which will be as flexible as Sylius. This plugin allows you to add dynamic blocks with images, text or HTML to your storefront as well as pages and FAQ section.

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

{{ bitbag_render_block('homepage_text_block') }}

{{ render(url('sylius_shop_partial_product_index_latest', {'count': 4, 'template': '@SyliusShop/Product/_horizontalList.html.twig'})) }}
{% endblock %}
```

### Pages

For rendering pages you can use `bitbag_shop_page_show` route which takes the `slug` as a parameter. You can also override the page template. 
For more information about how to do it, read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html). If you are lazy guy, take a look at 
`vendor/bitbag/cms-plugin/src/Resources/views/Page/show.html.twig` template, create `show.html.twig` file in `app/Resources/BitBagCmsPlugin/views` directory and paste 
 the vendor's `show.html.twig` file content to it. 
 Now you can do whatever you want with it :slightly_smiling_face:
 
 There's also a twig method which allows rendering the link template for the page by its code named `bitbag_render_page_link_by_code` which obviously takes the code as a parameter.

### WYSIWYG Editor (CKEditor or any other which supports Symfony)

For now you can install CKEditor, create proper form extension and replace `Textarea[Text]Type::class` with `CKEditorType::class`.
For more - take a look at [Symfony CKEditor installation manual](http://symfony.com/doc/master/bundles/IvoryCKEditorBundle/installation.html) and [Symfony form extension "how to" guide](https://symfony.com/doc/current/form/create_form_type_extension.html).
To see which forms you may want to extend, run `$ bin/console debug:container | grep bitbag.cms_plugin.form` command.

## Testing
```bash
$ composer install
$ bin/console assets:install web -e test
$ bin/console doctrine:schema:create -e test
$ bin/console server:run 127.0.0.1:8080 -d web -e test
$ open http://localhost:8080
$ vendor/bin/behat
$ vendor/bin/phpspec run
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.

## Support

Do you want us to customize this plugin for your specific needs? Write us an email on mikolaj.krol@bitbag.pl :computer:
