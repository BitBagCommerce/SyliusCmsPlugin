## Installation
```bash
$ composer require bitbag/cms-plugin
```

Add plugin dependencies to your config/bundles.php file:
```php
return [
    ...

    FOS\CKEditorBundle\FOSCKEditorBundle::class => ['dev' => true, 'test' => true], // WYSIWYG editor
    SitemapPlugin\SitemapPlugin::class => ['dev' => true, 'test' => true], // Sitemap support
    BitBag\SyliusCmsPlugin\BitBagSyliusCmsPlugin::class  => ['dev' => true, 'test' => true],
];
```
The first line above (FOSCKEditorBundle) might have been already added during composer require command.

Install WYSIWYG editor ([FOS CKEditor](https://symfony.com/doc/master/bundles/FOSCKEditorBundle/usage/ckeditor.html))

```bash
$ bin/console ckeditor:install
```

Import required config in your `config/packages/_sylius.yaml` file:

```yaml
# config/packages/_sylius.yaml

imports:
    ...
    
    - { resource: "@BitBagSyliusCmsPlugin/Resources/config/config.yml" }
```

Import routing in your `config/routes.yaml` file:

```yaml

# config/routes.yaml
...

bitbag_sylius_cms_plugin:
    resource: "@BitBagSyliusCmsPlugin/Resources/config/routing.yml"
```

Finish the installation by updating the database schema and installing assets:
```
$ bin/console doctrine:migrations:diff
$ bin/console doctrine:migrations:migrate
$ bin/console assets:install
$ bin/console sylius:theme:assets:install
```
