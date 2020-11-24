## Installation
```bash
$ composer require bitbag/cms-plugin
```

Add plugin dependencies to your `config/bundles.php` file:
```php
return [
    ...

    FOS\CKEditorBundle\FOSCKEditorBundle::class => ['all' => true], // WYSIWYG editor
    SitemapPlugin\SitemapPlugin::class => ['all' => true], // Sitemap support
    BitBag\SyliusCmsPlugin\BitBagSyliusCmsPlugin::class  => ['all' => true],
];
```
The first line above (FOSCKEditorBundle) might have been already added during composer require command.

Install WYSIWYG editor ([FOS CKEditor](https://symfony.com/doc/master/bundles/FOSCKEditorBundle/usage/ckeditor.html))

```bash
$ bin/console ckeditor:install
```

Since FOSCKEditorBundle 2.0, to make Twig render the WYSIWYG editor, you must add some configuration under the `twig.form_themes` config key:

```yaml
# Symfony 2/3: app/config/config.yml
# Symfony 4: config/packages/twig.yaml

twig:
    form_themes:
        - '@FOSCKEditor/Form/ckeditor_widget.html.twig'
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

If You have installed https://github.com/stefandoorn/sitemap-plugin according to its installation instructions
import optional sitemap providers:
```yaml
# config/services.yaml
...
imports:
...
    - { resource: "@BitBagSyliusCmsPlugin/Resources/config/services/sitemap_provider.yml" }
```

Finish the installation by updating the database schema and installing assets:
```
$ bin/console doctrine:migrations:diff
$ bin/console doctrine:migrations:migrate
$ bin/console assets:install --symlink
$ bin/console sylius:theme:assets:install --symlink
```

## Testing & running the plugin
```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn run gulp
$ bin/console assets:install public -e test
$ bin/console doctrine:schema:create -e test
$ bin/console server:run 127.0.0.1:8080 -d public -e test
$ open http://localhost:8080
$ vendor/bin/behat
$ vendor/bin/phpspec run
```
