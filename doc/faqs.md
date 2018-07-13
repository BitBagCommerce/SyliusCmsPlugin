# FAQs

Frequently asked question is a common part of each eCommerce website. You can add the in your admin
panel configuring question, answer and position. All results will be paginated in the store front.

## General usage

To render FAQs list, use the `bitbag_sylius_cms_plugin_shop_frequently_asked_question_index` route.

```twig
<a href="{{ path('bitbag_sylius_cms_plugin_shop_frequently_asked_question_index') }}">{{ 'app.ui.faqs'|trans }}</a>
```

## Customization

If you don't know how to override templates yet, 
read [Sylius template customization guide](http://docs.sylius.org/en/latest/customization/template.html).

You can create a template under `app/Resources/BitBagSyliusCmsPlugin/views/Shop/FrequentlyAskedQuestion` location.
Available templates you can override can be found under [this location](../src/Resources/views/Shop/FrequentlyAskedQuestion).
