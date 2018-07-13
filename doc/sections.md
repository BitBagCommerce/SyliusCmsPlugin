# Sections

With sections, you can organize your blocks and pages under some specific categories.
For instance, you can create a Blog section and display pages and blocks under it. 

## General usage

In order to render a page by section code, use:

```twig
<a href="{{ path('bitbag_sylius_cms_plugin_shop_page_index_by_section_code', {'sectionCode' : 'blog'}) }}">
    {{ 'app.ui.blog'|trans }}
</a>
```

If you want to list blocks by specific section, use:

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_block_index_by_section_code', {'sectionCode' : 'blog', 'template' : '@BitBagSyliusCmsPlugin/Shop/Block/index.html.twig'})) }}
```
