# WYSIWYG editor

This plugin comes with a default [FOSCKEditorBundle](https://github.com/FriendsOfSymfony/FOSCKEditorBundle) integration.
It has also been customized to use image upload feature. Every time you upload an image in the CKEditor, a new image media
is being created.

## General usage

You can use a custom [WysiwygType](../src/Form/Type/WysiwygType.php) any place you want the CKEditor to appear in.
Take [the BlockTranslationType](../src/Form/Type/Translation/BlockTranslationType.php) as an example.

## Configuration

If you want to customize any behavior of the CKEditor, you have to override one of these files: [CKEditor config](../src/Resources/config/fos_ck_editor/fos_ck_editor.yml) or [CKEditor js config](../src/Resources/views/Form/ckeditor_widget.html.twig)

**Useful links:**
- [CKEditor configuration](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html)
- [CKEditor DTD configuration](https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_dtd.html)


**Note:**
Remember to add your js configuration to `config/packages/twig.yaml` file:**
```yaml
# Symfony 2/3: app/config/config.yml
# Symfony 4: config/packages/twig.yaml

twig:
    form_themes:
        - 'path to your configuration'
```

## Extras

Some problems explained and solved in this [issue](https://github.com/BitBagCommerce/SyliusCmsPlugin/issues/411)

