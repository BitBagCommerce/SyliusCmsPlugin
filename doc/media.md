# Media

In this plugin media represents a digital assets, for instance an image, a video or simple PDF file.

Currently, it supports following media types:

- Image (img HTML tag)
- Video (video HTML tag)
- File (a HTML tag)

## General usage

You can render media in two ways:

By rendering a media code template:

```twig
{{ sylius_cms_render_media('media_code') }}
```
Function above can also take an additional parameter: `template`.

```twig
{{ sylius_cms_render_media('media_code', '@App/templates/example.html.twig')}}
```

Rendering a media code directly:

```twig
{{ render(path('sylius_cms_shop_media_render', {'code' : 'file', 'template' : '@App/Some/Template/_path.html.twig'})) }}
```

## Media provider

You can add your own media provider by adding a service with a tag named `sylius_cms.media_provider`:

```twig
app.media_provider.audio:
    class: Sylius\CmsPlugin\MediaProvider\GenericProvider
    arguments:
        - "@sylius_cms.media_uploader"
        - "@templating.engine.twig"
        - "@@SyliusCmsPlugin/Shop/Media/Show/audio.html.twig"
        - "media/audio"
    tags:
        - { name: sylius_cms.media_provider, type: audio, label: sylius_cms.ui.audio_provider }
```

## Customization

If you don't know how to override templates yet,
read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

Even if you can pass template argument to render media resource, you can change the global templates under `app/templates/bundles/SyliusCmsPlugin/Shop/Media` location.
Available templates you can override can be found under [this location](../src/Resources/views/Shop/Media).
