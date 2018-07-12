# Blocks

Blocks represent single parts of your Sylius web app, where you can put some content hardcoded in the 
template and change it in the future from admin panel.

## General usage 

In the admin panel, you can create block resources. It could be rendered in your twig templates using `bitbag_cms_render_block([block_code])` helper extension.
For instance, let's assume you created a block with `homepage_intro` code and want to render it on store homepage.
In your `app/Resources/views/SyliusShopBundle/Homepage/index.html.twig` file add the Twig filter like this:

```twig
{% extends '@SyliusShop/layout.html.twig' %}

{% block content %}

# The template is not a mandatory parameter

{{ render(path('bitbag_sylius_cms_plugin_shop_block_render', {'code' : 'homepage_header_image', 'template' : '@App/Some/Template/_path.html.twig'})) }}

# However, you can pass it to the `bitbag_cms_render_block` function if you wish :)

{{ bitbag_cms_render_block('homepage_intro') }}

{% endblock %}
```

To render a block by the product code, you can use `route`.

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_block_index_by_product_code', {'productCode' : product.code, 'template' : '@BitBagSyliusCmsPlugin/Shop/Block/index.html.twig'})) }}
```

## Customization

If you don't know how to override templates yet, 
read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

You can create a template under `app/Resources/BitBagSyliusCmsPlugin/views/Shop/Block/show.html.twig` and paste the default 
[show.html.twig](../src/Resources/views/Shop/Block/show.html.twig) content to it. Afterwards, clear your app cache 
and customize the file the way you need.
