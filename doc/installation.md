## Installation


1. *We work on stable, supported and up-to-date versions of packages. We recommend you to do the same.*

```bash
composer require bitbag/cms-plugin --no-scripts
```

2. Add plugin dependencies to your `config/bundles.php` file (if not added automatically):

```php
return [
    ...

    FOS\CKEditorBundle\FOSCKEditorBundle::class => ['all' => true], // WYSIWYG editor
    Sylius\CmsPlugin\BitBagSyliusCmsPlugin::class  => ['all' => true],
];
```

3. Install WYSIWYG editor ([FOS CKEditor](https://symfony.com/doc/master/bundles/FOSCKEditorBundle/usage/ckeditor.html))

```bash
bin/console ckeditor:install
```

**Note.** If you have an issue with the ckeditor not running, please try to install it using the `4.22.1` tag:

```bash
bin/console ckeditor:install --tag=4.22.1
```

For more information regardin `4.22.1` tag please visit the #485 issue.

#### If you are not using Symfony Flex, you need to add the following configuration under the `twig.form_themes` config key:

```yaml
# Symfony 2/3: app/config/config.yml
# Symfony 4: config/packages/twig.yaml

twig:
    form_themes:
        - '@FOSCKEditor/Form/ckeditor_widget.html.twig'
        - '@BitBagSyliusCmsPlugin/Form/ckeditor_widget.html.twig'
```

4. If you are not using Symfony Flex, import add following configs:
```yaml
# config/packages/_sylius.yaml

imports:
    ...
    
    - { resource: "@BitBagSyliusCmsPlugin/Resources/config/config.yml" }


# config/routes.yaml
...

sylius_cms_plugin:
    resource: "@BitBagSyliusCmsPlugin/Resources/config/routing.yml"
```

5. Finish the installation by updating the database schema and installing assets:

```bash
bin/console cache:clear

# If you used migrations in your project...
bin/console doctrine:migrations:migrate
# ... or if you use doctrine schema tool.
bin/cosole doctrine:schema:update --dump-sql # and --force switch when you're ready :)

bin/console assets:install --symlink
bin/console sylius:theme:assets:install --symlink
```

Note. In some cases the `--symlink` option [may trow some errors](https://github.com/Sylius/SyliusThemeBundle/issues/91). If you consider running the commands without `--symlink` option, please keep in mind to run them on every potential plugin update.

6. Add plugin assets to your project

We recommend you to use Webpack (Encore), for which we have prepared four different instructions on how to add this plugin's assets to your project:

- [Import webpack config](./01.1-webpack-config.md)*
- [Add entry to existing config](./01.2-webpack-entry.md)
- [Import entries in your entry.js files](./01.3-import-entry.md)
- [Your own custom config](./01.4-custom-solution.md)

<small>* Default option for plugin development</small>


However, if you are not using Webpack, here are instructions on how to add optimized and compressed assets directly to your project templates:

- [Non webpack solution](./01.5-non-webpack.md) 

## Testing & running the plugin
```bash
composer install
cd tests/Application
yarn install
yarn encore dev
APP_ENV=test bin/console assets:install
APP_ENV=test bin/console doctrine:schema:create
APP_ENV=test symfony server:start --port=8080 -d
cd ../..
open http://localhost:8080
vendor/bin/behat
vendor/bin/phpspec run
```
