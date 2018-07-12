# Medias

You can render media in two ways:

By rendering a media code template:

```twig
{{ bitbag_cms_render_media('media_code') }}
```

Or rendering a media code directly:

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_media_render', {'code' : 'file', 'template' : '@App/Some/Template/_path.html.twig'})) }}
```

### Media provider

You can add your own media provider by adding a service with a tag named `bitbag_sylius_cms_plugin.media_provider`

```php
app.media_provider.audio:
    class: BitBag\SyliusCmsPlugin\MediaProvider\AudioProvider
    arguments:
        - "@bitbag_sylius_cms_plugin.media_uploader"
        - "@templating.engine.twig"
        - "@@BitBagSyliusCmsPlugin/Shop/Media/Show/audio.html.twig"
        - "media/audio"
    tags:
        - { name: bitbag_sylius_cms_plugin.media_provider, type: audio, label: bitbag_sylius_cms_plugin.ui.audio_provider }
```
