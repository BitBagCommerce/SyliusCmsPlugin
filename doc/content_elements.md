# Content elements

Content elements are used to create a page or block content that will be displayed on the store's frontend.

## General usage

Currently, there are 11 predefined content elements available:
- **[Textarea](content_elements/textarea.md)** - a simple textarea with WYSIWYG editor
- **[Single media](content_elements/single_media.md)** - a single media from the media library
- **[Multiple media](content_elements/multiple_media.md)** - multiple media from the media library
- **[Heading](content_elements/heading.md)** - a simple heading from h1 to h6
- **[Products carousel](content_elements/products_carousel.md)** - a carousel with products
- **[Products carousel by Taxon](content_elements/products_carousel_by_taxon.md)** - a carousel with products from a specific taxon
- **[Products grid](content_elements/products_grid.md)** - a grid with products
- **[Products grid by Taxon](content_elements/products_grid_by_taxon.md)** - a grid with products from a specific taxon
- **[Taxons list](content_elements/taxons_list.md)** - a list of taxons
- **[Pages collection](content_elements/pages_collection.md)** - a collection of pages
- **[Spacer](content_elements/spacer.md)** - a simple spacer with a defined height in pixels

Instead of rendering block or page, you can render just content elements in your twig templates using `sylius_cms_render_content_elements([page|block])` helper extension,
where `page` or `block` is an instance of `Sylius\CmsPlugin\Entity\PageInterface` or `Sylius\CmsPlugin\Entity\BlockInterface`.

## Customization

### Templates

Each of the content elements has its own template that you can override.

If you don't know how to override templates yet,
read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

You can create a template under `app/templates/bundles/SyliusCmsPlugin/Shop/ContentElement` location.
Available templates you can override can be found under [this location](../src/Resources/views/Shop/ContentElement).

### Creating a new content element

If you want to create a new content element, you need to follow these steps:

1. Create a new form type under `src/Form/Type/ContentElements` location. Define your fields and remember to define public const `TYPE` with a unique name.
For example, you can create a new form type called `Text`:

```php
final class TextContentElementType extends AbstractType
{
    public const TYPE = 'text';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, TextType::class, [
                'label' => 'sylius_cms.ui.content_elements.type.' . self::TYPE,
            ])
        ;
    }
}
```

2. If your form type have constructor with some arguments, define constant parameter in `config/parameters.yaml` or yours any other `yaml` file:

```yaml
parameters:
    sylius_cms.content_elements.type.text: !php/const 'YourNamespace\Form\Type\ContentElements\TextContentElementType::TYPE'
```

If your form type doesn't have any constructor arguments, you can skip this step, because compiler pass will automatically define it for you.


3. If your form type have constructor with some arguments, you must define form type in service container under `config/services.yml` with correct tags:

```yaml
services:
    sylius_cms.form.type.content_element.text:
        class: YourNamespace\Form\Type\ContentElements\TextContentElementType
        arguments: [...]
        tags:
            - { name: 'sylius_cms.content_elements.type', key: '%sylius_cms.content_elements.type.text%' }
            - { name: 'form.type' }
```

If your form type doesn't have any constructor arguments, you can skip this step, because compiler pass will automatically register it for you.

4. Create a new renderer class under `src/Renderer/ContentElement` location. Extend `Sylius\CmsPlugin\Renderer\ContentElement\AbstractContentElement` class.
For example, you can create a new renderer called `TextContentElementRenderer`:

```php
final class TextContentElementRenderer extends AbstractContentElement
{
    public function supports(ContentConfigurationInterface $contentConfiguration): bool
    {
        return TextContentElementType::TYPE === $contentConfiguration->getType();
    }

    public function render(ContentConfigurationInterface $contentConfiguration): string
    {
        $text = $contentConfiguration->getConfiguration()['text'];

        return $this->twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => $this->template,
            'text' => $text,
        ]);
    }
}
```

5. Register your renderer with tag in service container under `config/services.yml`:

```yaml
services:
    sylius_cms.renderer.content_element.text:
        class: YourNamespace\Renderer\ContentElement\TextContentElementRenderer
        arguments:
            - '@twig'
        tags:
            - { 
                name: 'sylius_cms.renderer.content_element',
                template: '@YourNamespace/Shop/ContentElement/_text.html.twig',
                form_type: 'YourNamespace\Form\Type\ContentElements\TextContentElementType'
            }
```

Define form_type only if your form type doesn't have constructor with additional arguments.

6. Finally, create a new template under `templates/bundles/SyliusCmsPlugin/Shop/ContentElement` location.
For example, you can create a new template called `_text.html.twig`:

```twig
<p>{{ text }}</p>
```
