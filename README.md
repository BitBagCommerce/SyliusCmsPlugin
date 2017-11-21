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

# Demo

We created a demo app with some useful use-cases of the plugin! Visit [cms.bitbag.shop](https://cms.bitbag.shop) to take a look at it. The admin as always can be accessed under [cms.bitbag.shop/admin](https://cms.bitbag.shop/admin) link and `sylius: sylius` credentials.

## Overview

Almost each eCommerce app has to present some content. Managing it is often done via third-party libraries like Wordpress, eZ Platform or a built-in content management system. As Sylius does not have a CMS in the standard platform, we decided to develop our own which will be as flexible as Sylius. This plugin allows you to add dynamic blocks with images, text or HTML to your storefront as well as pages and FAQs section.

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
        
        new BitBag\SyliusCmsPlugin\BitBagSyliusCmsPlugin(),
    ]);
}
```

Import required config in your `app/config/config.yml` file:

```yaml
# app/config/config.yml

imports:
    ...
    
    - { resource: '@BitBagSyliusCmsPlugin/Resources/config/config.yml' }
```

Import routing in your `app/config/routing.yml` file:

```yaml

# app/config/routing.yml
...

bitbag_sylius_cms_plugin:
    resource: '@BitBagSyliusCmsPlugin/Resources/config/routing.yml'
```

## Usage

### Blocks

If you don't know how to override templates yet, read  [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

In the admin panel, you can now create image and text blocks. Both can be rendered in your twig templates using `bitbag_render_block([block_code])` helper extension.
For instance, let's assume you have created a block with `homepage_text_block` code and want to render it on store homepage.
In your `app/Resources/views/SyliusShopBundle/Homepage/index.html.twig` file add the twig filter like this:

```twig
{% extends '@SyliusShop/layout.html.twig' %}

{% block content %}

{{ render(path('bitbag_sylius_cms_plugin_shop_block_render', {'code' : 'homepage_header_image', 'template' : '@App/Some/Template/_path.html.twig'})) }}

{{ bitbag_render_block('homepage_text_block') }}

{% endblock %}
```

To render a block by the product code, you can use `route`.

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_block_index_by_product_code', {'productCode' : product.code, 'template' : '@BitBagSyliusCmsPlugin/Shop/Block/index.html.twig'})) }}
```

### Pages

You can render page in two ways:

By rendering a page link template:

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_page_show_link_by_code', {'code' : 'about', 'template' : '@BitBagSyliusCmsPlugin/Shop/Page/Show/_link.html.twig'})) }}
```

Or rendering a page link directly:

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_page_show', {'slug' : 'about'})) }}
```

### Sections

With sections, you can organize your blocks and pages under some specific categories.
For instance, you can create a Blog section and display pages and blocks under it. You also have a set of routes to do it:

```twig
<a href="{{ path('bitbag_sylius_cms_plugin_shop_page_index_by_section_code', {'sectionCode' : 'blog'}) }}">
    {{ 'app.ui.blog'|trans }}
</a>
```

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_block_index_by_section_code', {'sectionCode' : 'blog', 'template' : '@BitBagSyliusCmsPlugin/Shop/Block/index.html.twig'})) }}
```

### FAQs

To render FAQs list, use the `bitbag_sylius_cms_plugin_shop_frequently_asked_question_index` route.

```twig
<a href="{{ path('bitbag_sylius_cms_plugin_shop_frequently_asked_question_index') }}">{{ 'app.ui.faqs'|trans }}</a>
```

### Fixtures

Sometimes you'll need to set up your environment quickly or even load some primary CMS data on your server. You can take a look at `tests/Application/app/config/fixtures.yml` file to see how you can configure fixtures.

### WYSIWYG Editor (CKEditor or any other which supports Symfony)

For now you can install CKEditor, create proper form extension and replace `Textarea[Text]Type::class` with `CKEditorType::class`.
For more - take a look at [FriendsOfSylius WYSIWYG step by step guide](https://github.com/FriendsOfSylius/SyliusGoose/blob/master/StepByStep/WYSIWYG_EDITOR_IN_ANY_FORM.md).
To see which forms you may want to extend, run `$ bin/console debug:container | grep bitbag.cms_plugin.form` command.

### Use-case

Go to the `tests/Application/app/Resources` or visit [cms.bitbag.shop](https://cms.bitbag.shop) demo page.

## Testing
```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn run gulp
$ bin/console assets:install web -e test
$ bin/console doctrine:schema:create -e test
$ bin/console server:run 127.0.0.1:8080 -d web -e test
$ open http://localhost:8080
$ bin/behat
$ bin/phpspec run
```

## Contribution

Learn more about our contribution workflow on http://docs.sylius.org/en/latest/contributing/.

## Support

Want us to help you with this plugin? Write us an email on mikolaj.krol@bitbag.pl :computer:
