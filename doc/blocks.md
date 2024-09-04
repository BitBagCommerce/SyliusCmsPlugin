# Blocks

Blocks represent single parts of your Sylius web app, where you can put some content elements via the admin panel.
Blocks can be placed on the homepage, product page, or any other page of your store.

## General usage

### Rendering the block

In the admin panel, you can create block resources. It could be rendered in your twig templates using `bitbag_cms_render_block([block_code])` helper extension.
For instance, let's assume you created a block with `homepage_intro` code and want to render it on store homepage.
In your `app/Resources/views/SyliusShopBundle/Homepage/index.html.twig` file add the Twig filter like this:

```twig
{% extends '@SyliusShop/layout.html.twig' %}

{% block content %}

{{ bitbag_cms_render_block('homepage_intro') }}

{% endblock %}
```

`{{ bitbag_cms_render_block([block_code]) }}` function can also take two additional parameters: `template` and `context`.

`template` allows you to render a block with a custom template. For instance:

```twig
{{ bitbag_cms_render_block('homepage_intro', '@App/Some/Template/_path.html.twig') }}
```

`context` allows you to pass additional variables to the block template. It can be one of three types: 
- `ProductInterface` 
- `TaxonInterface`
- `array`
 
For instance:

```twig
{{ bitbag_cms_render_block('homepage_intro', null, {'some_variable': 'some_value'}) }}
{{ bitbag_cms_render_block('homepage_intro', null, product) }}
{{ bitbag_cms_render_block('homepage_intro', null, taxon) }}
```

When you pass `ProductInterface` or `TaxonInterface` as a context, the block will be rendered only if it is assigned to the given product or taxon
in the admin panel.

## Customization

### Override block template

If you don't know how to override templates yet,
read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

Even if you can pass template argument to render block resource, you can change the global templates under `app/templates/bundles/BitBagSyliusCmsPlugin/Shop/Block` location.
Available templates you can override can be found under [this location](../src/Resources/views/Shop/Block).
