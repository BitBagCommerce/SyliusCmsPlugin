# Customization

You can customize this plugin using:

- [Sylius templating overriding system](http://docs.sylius.org/en/latest/customization/template.html)
- [Symfony decorator pattern](https://symfony.com/doc/current/service_container/service_decoration.html)
- [Symfony form extension](https://symfony.com/doc/current/form/create_form_type_extension.html)

In order to check what services are available with this plugin, run the following command:

```bash
$ bin/console debug:container sylius_cms_plugin
```

**Note:**

*All forms are prefixed with 'sylius_cms_plugin.form.*'*

If you want to check what routes are available with this plugin, use:

```bash
$ bin/console debug:router | grep sylius_cms_plugin
```

To check parameters available with the plugin, execute:

```bash
$ bin/console debug:container --parameters | grep bitbag
```
## How to disable localised URLs?
Customise vendor routing in the file `app/Resources/BitBagSyliusCmsPlugin/config/routing.yml` (create if not exist).
Add:
```
sylius_cms_plugin_admin:
    resource: "@BitBagSyliusCmsPlugin/Resources/config/routing/admin.yml"
    prefix: /admin

sylius_cms_plugin_shop:
    resource: "@BitBagSyliusCmsPlugin/Resources/config/routing/shop.yml"
    prefix: /

sylius_sitemap:
   resource: "@SitemapPlugin/Resources/config/routing.yml"
```
## Testing

```bash
$ composer install
$ cd tests/Application
$ yarn install
$ yarn run gulp
$ bin/console doctrine:schema:create -e test
$ bin/console ckeditor:install
$ bin/console assets:install public -e test
$ bin/console server:run 127.0.0.1:8080 -d public -e test
$ open http://localhost:8080
$ bin/behat
$ bin/phpspec run
```
