<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

final class CollectionType extends AbstractResourceType
{
    public const PAGE = 'page';

    public const BLOCK = 'block';

    public const MEDIA = 'media';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'sylius_cms_plugin.ui.code',
                'disabled' => null !== $builder->getData()->getCode(),
            ])
            ->add('name', TextType::class, [
                'label' => 'sylius_cms_plugin.ui.name',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'sylius_cms_plugin.ui.type',
                'choices' => [
                    'sylius_cms_plugin.ui.page' => self::PAGE,
                    'sylius_cms_plugin.ui.block' => self::BLOCK,
                    'sylius_cms_plugin.ui.media' => self::MEDIA,
                ],
            ])
            ->add('pages', PageAutocompleteChoiceType::class, [
                'label' => 'sylius_cms_plugin.ui.pages',
                'multiple' => true,
            ])
            ->add('blocks', BlockAutocompleteChoiceType::class, [
                'label' => 'sylius_cms_plugin.ui.blocks',
                'multiple' => true,
            ])
            ->add('media', MediaAutocompleteChoiceType::class, [
                'label' => 'sylius_cms_plugin.ui.media',
                'multiple' => true,
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
            });
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_plugin_collection';
    }
}
