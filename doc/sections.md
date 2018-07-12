# Sections

With sections, you can organize your blocks and pages under some specific categories.
For instance, you can create a Blog section and display pages and blocks under it. You also have a set of routes to do it:

```twig
<a href="{{ path('bitbag_sylius_cms_plugin_shop_page_index_by_section_code', {'sectionCode' : 'blog'}) }}">
    {{ 'app.ui.blog'|trans }}
</a>
```

```twig
{{ render(path('bitbag_sylius_cms_plugin_shop_block_index_by_section_code', {'sectionCode' : 'blog', 'template' : '@BitBagSyliusCmsPlugin/Shop/Block/index.html.twig'})) }}
```
