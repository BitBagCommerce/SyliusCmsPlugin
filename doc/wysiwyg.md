# WYSIWYG editor

For now you can install CKEditor, create proper form extension and replace `Textarea[Text]Type::class` with `CKEditorType::class`.
For more - take a look at [FriendsOfSylius WYSIWYG step by step guide](https://github.com/FriendsOfSylius/SyliusGoose/blob/master/StepByStep/WYSIWYG_EDITOR_IN_ANY_FORM.md).
To see which forms you may want to extend, run `$ bin/console debug:container | grep bitbag_sylius_cms_plugin.form` command.
