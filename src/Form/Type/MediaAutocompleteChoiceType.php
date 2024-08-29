<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class MediaAutocompleteChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'resource' => 'sylius_cms_plugin.media',
            'choice_name' => 'name',
            'choice_value' => 'code',
            'media_type' => [
                MediaInterface::IMAGE_TYPE,
                MediaInterface::FILE_TYPE,
                MediaInterface::VIDEO_TYPE,
            ],
        ]);
    }

    public function buildView(
        FormView $view,
        FormInterface $form,
        array $options,
    ): void {
        $view->vars['remote_criteria_type'] = 'contains';
        $view->vars['remote_criteria_name'] = 'phrase';
        $view->vars['media_type'] = $options['media_type'];
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_media_autocomplete_choice';
    }

    public function getParent(): string
    {
        return ResourceAutocompleteChoiceType::class;
    }
}
