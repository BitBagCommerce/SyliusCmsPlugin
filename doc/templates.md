# Page/Block Templates

Templates allow you to define and select the layout of your pages and blocks.

## General usage

By default, the blocks and pages have its own templates. You can create your own templates and use it in specific blocks or pages.

### Creating a new template

1. Go to the `config/packages/cms_plugin.yaml` file.
2. Define your templates in following format:
```yaml
sylius_cms:
	templates:
		pages:
			- "@SyliusCMSPlugin/Shop/MyPage/template.twig"
			- "@SyliusCMSPlugin/Shop/MySecondPage/template.twig"
		blocks:
			- "@SyliusCMSPlugin/Shop/MyPage/template.twig"
			- "@SyliusCMSPlugin/Shop/MySecondPage/template.twig
```
3. Create a new template file. For example, `templates/bundles/SyliusCMSPlugin/Shop/MyPage/template.twig`.
4. Go to the Block/Page form and select your template from the list.
