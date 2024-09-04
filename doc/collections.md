# Collections

Collections are a way to group multiple pages, blocks or media together. 
They are useful for organizing things in a way that makes sense to you. \
For example, you might want to group all of your blog posts together in a collection called `Blog`.
Or you might want to group all of your specific blocks together in a collection called `Homepage blocks`.

## General usage

### Rendering the collection

In the admin panel, you can create collection resources. 
It could be rendered in your twig templates using `bitbag_cms_render_collection([collection_code])` helper extension.

`{{ bitbag_cms_render_collection([collection_code]) }}` function can also take two additional parameters: `countToRender` and `template`.

`countToRender` allows you to render a specific number of items from the collection. For instance:

```twig
{{ bitbag_cms_render_collection('homepage_blocks', 3) }}
```

`template` allows you to render a collection with a custom template. For instance:

```twig
{{ bitbag_cms_render_collection('homepage_blocks', null, '@App/Some/Template/_path.html.twig') }}
```

By default, collection items are sorted by object ID parameter. If you want to change it, you can use decorator strategy.
You can read more about it [here](https://symfony.com/doc/current/service_container/service_decoration.html).

## Customization

### Override collection template

If you don't know how to override templates yet, read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

Even if you can pass template argument to render collection resource, you can change the global templates under `app/templates/bundles/BitBagSyliusCmsPlugin/Shop/Collection` location. 
Available templates you can override can be found under [this location](../src/Resources/views/Shop/Collection).
