# Pages

Pages represent a customizable web page, you can adjust to your needs in admin panel.

## Page sections

Page contain 4 main editable sections:
- **General settings** - where you can set page name, code, channels, collections and publish at. It also contains a Preview button, which allows you to preview the page.
- **Content elements** - where you can add content elements to the page, read more about content elements [here](content_elements.md).
- **Teaser** - where you can set image, title and content. Teaser is a small preview of the page. It is used during rendering a collection of pages.
- **SEO** - where you can set slug, meta title, meta keywords and meta description.

## General usage

### Rendering the page

Once you created a page in the admin panel, you can render page in two ways:

By rendering a page link template:

```twig
{{ render(path('sylius_cms_shop_page_show_link_by_code', {'code' : 'about', 'template' : '@SyliusCmsPlugin/Shop/Page/Show/_link.html.twig'})) }}
```

Or rendering a page link directly:

```twig
{{ render(path('sylius_cms_shop_page_show', {'slug' : 'about'})) }}
```

### Visiting the page

Page URL is generated based on the page slug. Full link looks like this: `domain.com/{locale}/page/{slug}`.

## Customization

### Override page template

If you don't know how to override templates yet,
read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

You can create a template under `app/templates/bundles/SyliusCmsPlugin/Shop/Page` location.
Available templates you can override can be found under [this location](../src/Resources/views/Shop/Page).
