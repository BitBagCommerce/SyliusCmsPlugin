<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class WysiwygType extends AbstractType
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'sylius_cms_plugin.ui.content',
            'config' => [
                'filebrowserUploadUrl' => $this->urlGenerator->generate('sylius_cms_plugin_admin_upload_editor_image'),
                'bodyId' => 'bitbag-ckeditor',
            ],
        ]);
    }

    public function getParent(): string
    {
        return CKEditorType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_wysiwyg';
    }
}
