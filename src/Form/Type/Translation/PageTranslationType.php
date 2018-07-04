<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type\Translation;

use BitBag\SyliusCmsPlugin\Form\Type\PageImageType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\RouterInterface;

final class PageTranslationType extends AbstractResourceType
{
    /** @var RouterInterface */
    private $router;

    public function __construct(string $dataClass, $validationGroups = [], RouterInterface $router)
    {
        parent::__construct($dataClass, $validationGroups);

        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.slug',
            ])
            ->add('breadcrumb', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.breadcrumb',
                'required' => false,
            ])
            ->add('nameWhenLinked', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.name_when_linked',
                'required' => false,
            ])
            ->add('descriptionWhenLinked', TextareaType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.description_when_linked',
                'required' => false,
            ])
            ->add('image', PageImageType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('metaKeywords', TextareaType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.meta_keywords',
                'required' => false,
            ])
            ->add('metaDescription', TextareaType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.meta_description',
                'required' => false,
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.content',
                'config' => [
                    'filebrowserUploadUrl' => $this->router->generate('bitbag_sylius_cms_plugin_admin_upload_editor_image'),
                ],
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_page_translation';
    }
}
