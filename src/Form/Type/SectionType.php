<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Form\Type\Translation\SectionTranslationType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

final class SectionType extends AbstractResourceType
{
    public const PAGE = 'page';

    public const BLOCK = 'block';

    public const MEDIA = 'media';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.code',
                'disabled' => null !== $builder->getData()->getCode(),
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.type',
                'choices' => [
                    'bitbag_sylius_cms_plugin.ui.page' => self::PAGE,
                    'bitbag_sylius_cms_plugin.ui.block' => self::BLOCK,
                    'bitbag_sylius_cms_plugin.ui.media' => self::MEDIA,
                ],
            ])
            ->add('pages', PageAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.pages',
                'multiple' => true,
            ])
            ->add('blocks', BlockAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.blocks',
                'multiple' => true,
            ])
            ->add('media', MediaAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.media',
                'multiple' => true,
                'media_type' => MediaInterface::IMAGE_TYPE,
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'entry_type' => SectionTranslationType::class,
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event): void {
                $formData = $event->getData();
                switch ($formData['type']) {
                    case self::PAGE:
                        unset($formData['blocks'], $formData['media']);
                        break;
                    case self::BLOCK:
                        unset($formData['pages'], $formData['media']);
                        break;
                    case self::MEDIA:
                        unset($formData['pages'], $formData['blocks']);
                        break;
                }

                $event->setData($formData);
            })
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_section';
    }
}
