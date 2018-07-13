# Using Twig functions in admin panel

With CMS 2.0+, you can use some Twig functions in the admin panel content. It's extremely helpful
if you wish to render a block within a page, or what's even more common - a media, for instance an
image or video.

So far, only following functions are allowed:

```yaml
parameters:
    bitbag_cms.twig.admin_functions:
        - bitbag_cms_render_block
        - bitbag_cms_render_media
```

As this is a parameter, you can easily customize its value in your `config.yml`.

**Note:**

*With the parser, you are supposed to use the function with `{{ function_name('foo', 'bar') }}` format. 
All characters, including spaces and apostrophes are recognized. Only string parameters are allowed.*

*If for some reason the function would not be able to execute, an empty string result will be returned.*

*To render the interpretable content, you need to use a special `{{ bitbag_cms_render_content([resource]) }}` Twig function. 
The resource needs to implement [ContentableInterface](../src/Entity/ContentableInterface.php). 
For an example, take a look at the Block's [show.html.twig](../src/Resources/views/Shop/Block/show.html.twig)* file.
