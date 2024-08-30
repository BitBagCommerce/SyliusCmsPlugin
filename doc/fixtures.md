# Fixtures

This plugin comes with some default fixtures you can use to set up you project easily by configuring 
some necessary data in YAML file, which you can load to your database.

If you are not familiar with the Sylius fixtures concept yet, please 
read [this documentation page](http://docs.sylius.com/en/1.2/book/architecture/fixtures.html).


## General usage

As you can see in [here](../tests/Application/config/packages/sylius_cms.yml), cms fixtures are configured to be run under `default` suite. It means that after installing plugin all you need to do is run `bin/console sylius:fixtures:load` and all of cms fixtures will load as well.
