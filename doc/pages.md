# Pages

Pages represent a customizable web page, you can adjust to your needs in admin panel. 

## General usage

Once you created a page in the admin panel, you can render page in two ways:

By rendering a page link template:

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_page_show_link_by_code', {'code' : 'about', 'template' : '@BitBagSyliusCmsPlugin/Shop/Page/Show/_link.html.twig'})) }}
```

Or rendering a page link directly:

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_page_show', {'slug' : 'about'})) }}
```

### Pages for product grouped by section

Let's assume you associated pages to specific products. You can render them grouped by section in your product view by using 

```twig
{{ bitbag_cms_render_product_pages(product) }}
```

Twig function. This is where `nameWhenLinked` and `descriptionWhenLinked` fields are used. If you associate pages to 
specific sections, they will be displayed in columns titled with section name.

## Customization

If you don't know how to override templates yet, 
read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

You can create a template under `app/Resources/BitBagSyliusCmsPlugin/views/Shop/Page` location.
Available templates you can override can be found under [this location](../src/Resources/views/Shop/Page).
