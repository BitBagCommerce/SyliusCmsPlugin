# WYSIWYG editor

This plugin comes with a default [FOSCKEditorBundle](https://github.com/FriendsOfSymfony/FOSCKEditorBundle) integration.
It has also been customized to use image upload feature. Every time you upload an image in the CKEditor, a new image media
is being created. 

## General usage

You can use a custom [WysiwygType](../src/Form/Type/WysiwygType.php) any place you want the CKEditor to appear in.
Take [the BlockTranslationType](../src/Form/Type/Translation/BlockTranslationType.php) as an example.

**Note:**

*In the WYSIWYG fields, you can use Twig function nesting. Read more [here](twig-functions-in-admin.md).*
