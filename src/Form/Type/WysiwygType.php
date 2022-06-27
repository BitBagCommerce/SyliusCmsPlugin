<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class WysiwygType extends AbstractType
{
    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => 'bitbag_sylius_cms_plugin.ui.content',
            'config' => [
                'filebrowserUploadUrl' => $this->urlGenerator->generate('bitbag_sylius_cms_plugin_admin_upload_editor_image'),
                'bodyId' => 'bitbag-ckeditor',
                'removePlugins' => 'exportpdf',
            ],
        ]);
    }

    public function getParent(): string
    {
        return CKEditorType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_wysiwyg';
    }
}
