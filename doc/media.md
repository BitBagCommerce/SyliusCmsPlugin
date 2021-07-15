# Media

In this plugin media represents a digital assets, for instance an image, a video or simple PDF file.

Currently, it supports following media types:

- Image (img HTML tag)
- Video (video HTML tag)
- File (a HTML tag)

## General usage

You can render media in four ways:

By rendering a media code template:

```twig
{{ bitbag_cms_render_media('media_code') }}
```

Rendering a media code directly:

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_media_render', {'code' : 'file', 'template' : '@App/Some/Template/_path.html.twig'})) }}
```

If you want to list media by specific section. Useful for displaying set of images. For example, using "gallery" section you can group set of images and display them as gallery, or even slider.

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_media_index_by_section_code', {'sectionCode' : 'gallery', 'template' : '@App/Some/Template/_path.html.twig'})) }}
```

Or by providing custom twig template. Useful when you want to render media in a different template:

```{{ bitbag_cms_render_media('media_code', '@App/templates/example.html.twig')}}```

### Media provider

You can add your own media provider by adding a service with a tag named `bitbag_sylius_cms_plugin.media_provider`:

```php
app.media_provider.audio:
    class: BitBag\SyliusCmsPlugin\MediaProvider\GenericProvider
    arguments:
        - "@bitbag_sylius_cms_plugin.media_uploader"
        - "@templating.engine.twig"
        - "@@BitBagSyliusCmsPlugin/Shop/Media/Show/audio.html.twig"
        - "media/audio"
    tags:
        - { name: bitbag_sylius_cms_plugin.media_provider, type: audio, label: bitbag_sylius_cms_plugin.ui.audio_provider }
```

## Customization

If you don't know how to override templates yet, 
read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

You can create a template under `app/Resources/BitBagSyliusCmsPlugin/views/Shop/Media` location.
Available templates you can override can be found under [this location](../src/Resources/views/Shop/Media).
