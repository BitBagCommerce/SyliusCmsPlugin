<?php

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use Doctrine\DBAL\Types\TextType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;

final class MediaType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.code',
                'disabled' => null !== $builder->getData()->getCode(),
            ])
            ->add('file', FileType::class, [
                'required' => false,
                'label' => 'bitbag_sylius_cms_plugin.ui.file',
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_media';
    }
}
