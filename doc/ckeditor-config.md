1. Add plugin dependencies to your `config/bundles.php` file:

```php
return [
    ...

    FOS\CKEditorBundle\FOSCKEditorBundle::class => ['all' => true], 
    BitBag\SyliusCmsPlugin\BitBagSyliusCmsPlugin::class  => ['all' => true],
];
```

Install CKeditor ([FOS CKEditor](https://symfony.com/doc/master/bundles/FOSCKEditorBundle/usage/ckeditor.html))

```bash
$ bin/console ckeditor:install
```

**Note.** If you have an issue with CKEditor not running, please try installing it using the `4.22.1` tag:

```bash
$ bin/console ckeditor:install --tag=4.22.1
```

For more information regarding the `4.22.1` tag, please visit the #485 issue.

Since FOSCKEditorBundle 2.0, to make Twig render the WYSIWYG editor, you must add some configuration under the `twig.form_themes` config key:

```yaml
# Symfony 2/3: app/config/config.yml
# Symfony 4: config/packages/twig.yaml

twig:
    form_themes:
        - '@FOSCKEditor/Form/ckeditor_widget.html.twig'
        - '@BitBagSyliusCmsPlugin/Form/ckeditor_widget.html.twig'
```
