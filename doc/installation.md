## Installation
```bash
$ composer require bitbag/cms-plugin
```
    
Add plugin dependencies to your AppKernel.php file (note the new compiler pass):
```php
public function registerBundles()
{
    return array_merge(parent::registerBundles(), [
        ...
        
        new \FOS\CKEditorBundle\FOSCKEditorBundle(), // WYSIWYG editor
        new \BitBag\SyliusCmsPlugin\BitBagSyliusCmsPlugin(),
    ]);
}

protected function build(ContainerBuilder $container)
{
    ...

    $container->addCompilerPass(new \BitBag\SyliusCmsPlugin\DependencyInjection\Compiler\ImporterCompilerPass());
}
```

Install WYSIWYG editor ([FOS CKEditor](https://symfony.com/doc/master/bundles/FOSCKEditorBundle/usage/ckeditor.html))

```bash
$ bin/console ckeditor:install
```

Import required config in your `app/config/config.yml` file:

```yaml
# app/config/config.yml

imports:
    ...
    
    - { resource: "@BitBagSyliusCmsPlugin/Resources/config/config.yml" }
```

Import routing in your `app/config/routing.yml` file:

```yaml

# app/config/routing.yml
...

bitbag_sylius_cms_plugin:
    resource: "@BitBagSyliusCmsPlugin/Resources/config/routing.yml"
```

Finish the installation by updating the database schema and installing assets:
```
$ bin/console doctrine:schema:update --force
$ bin/console assets:install
$ bin/console sylius:theme:assets:install
```

### Sitemap integration
This plugin has a ready to go integration with [Sylius Sitemap Plugin](https://github.com/stefandoorn/sitemap-plugin).

To enable the integration you need to add the following to your `app/config/config.yml` file:
```yaml
# app/config/config.yml
imports:
    ...
    - { resource: "@BitBagSyliusCmsPlugin/Resources/config/services/sitemap_provider.yml" }
```
