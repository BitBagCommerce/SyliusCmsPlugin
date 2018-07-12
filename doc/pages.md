# Pages

You can render page in two ways:

By rendering a page link template:

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_page_show_link_by_code', {'code' : 'about', 'template' : '@BitBagSyliusCmsPlugin/Shop/Page/Show/_link.html.twig'})) }}
```

Or rendering a page link directly:

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_page_show', {'slug' : 'about'})) }}
```

### Pages for product grouped by section

You can render page by function Twig:

```twig
{{ bitbag_cms_render_product_pages(product) }}
```
