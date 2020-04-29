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

### Render product pages by section

Let's assume you associated pages to specific products. You can render them grouped by section in your product view by using 

```twig
{{ bitbag_cms_render_product_pages(product) }}
```

Twig function. This is where `nameWhenLinked` and `descriptionWhenLinked` fields are used. If you associate pages to 
specific sections, they will be displayed in columns titled with section name.

### Render link to page from its code

If you want to create a link to a page from its code, you can do either with `bitbag_cms_render_link_for_code` or `bitbag_cms_get_link_for_code` twig functions. These functions will automatically generate a link with the correct locale.

You can define attributes to customize the tag. You can also customize the displayed name (by default the function will try to display the name when linked, if it is not defined, it will fallback to the page name).

If you only need the link, you can use `bitbag_cms_get_link_for_code`.

You can display a message if the page wasn't found with the `notFoundMessage` option.

```twig
{{ bitbag_cms_render_link_for_code('code') }}
{{ bitbag_cms_render_link_for_code('code', { attr: { class: 'ui button' }, name: 'Custom name' }) }}
{{ bitbag_cms_render_link_for_code('code', {}, 'custom/template.html.twig') }}
{{ bitbag_cms_get_link_for_code('code') }}
{{ bitbag_cms_render_link_for_code('wrong-code', { notFoundMessage: 'Page not found' }) }}
{{ bitbag_cms_get_link_for_code('wrong-code', { notFoundMessage: 'Page not found' }) }}

```

Will render:

```html
<a href="/{_locale}/pages/{slug}">Name when linked</a>
<a href="/{_locale}/pages/{slug}" class="ui button">Custom name</a>
<!-- depends on custom/template.html.twig -->
/{_locale}/pages/{slug}
Page not found
Page not found
```

## Customization

If you don't know how to override templates yet, 
read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

You can create a template under `app/Resources/BitBagSyliusCmsPlugin/views/Shop/Page` location.
Available templates you can override can be found under [this location](../src/Resources/views/Shop/Page).
