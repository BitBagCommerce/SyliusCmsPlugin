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
        new \SitemapPlugin\SitemapPlugin(), // Sitemap support
        new \BitBag\SyliusCmsPlugin\BitBagSyliusCmsPlugin(),
    ]);
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
$ bin/console doctrine:migrations:diff
$ bin/console doctrine:migrations:migrate
$ bin/console assets:install
$ bin/console sylius:theme:assets:install
```
