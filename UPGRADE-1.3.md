# UPGRADE FROM `v1.2.X` TO `v1.3.0`

## Application

* Run `composer require sylius/sylius:~1.3.0 --no-update`

* Add the following code in your `behat.yml(.dist)` file:

    ```yaml
    default:
        extensions:
            FriendsOfBehat\SymfonyExtension:
                env_file: ~  
    ```
    
* Incorporate changes from the following files into plugin's test application:

    * [`tests/Application/package.json`](https://github.com/Sylius/PluginSkeleton/blob/1.3/tests/Application/package.json) ([see diff](https://github.com/Sylius/PluginSkeleton/compare/1.2...1.3#diff-726e1353c14df7d91379c0dea6b30eef)) 
    * [`tests/Application/.babelrc`](https://github.com/Sylius/PluginSkeleton/blob/1.3/tests/Application/.babelrc) ([see diff](https://github.com/Sylius/PluginSkeleton/compare/1.2...1.3#diff-a2527d9d8ad55460b2272274762c9386))
    * [`tests/Application/.eslintrc.js`](https://github.com/Sylius/PluginSkeleton/blob/1.3/tests/Application/.eslintrc.js) ([see diff](https://github.com/Sylius/PluginSkeleton/compare/1.2...1.3#diff-396c8c412b119deaa7dd84ae28ae04ca``))
     
* Update PHP and JS dependencies by running `composer update` and `(cd tests/Application && yarn upgrade)`

* Clear cache by running `(cd tests/Application && bin/console cache:clear)`

* Install assets by `(cd tests/Application && bin/console assets:install web)` and `(cd tests/Application && yarn build)`

* optionally, remove the build for PHP 7.1. in `.travis.yml`
