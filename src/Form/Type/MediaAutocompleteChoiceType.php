<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceAutocompleteChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class MediaAutocompleteChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'resource' => 'bitbag_sylius_cms_plugin.media',
            'choice_name' => 'name',
            'choice_value' => 'code',
            'media_type' => null,
        ]);

        $resolver->setAllowedValues('media_type', [
            MediaInterface::IMAGE_TYPE,
            MediaInterface::FILE_TYPE,
            MediaInterface::VIDEO_TYPE,
            null,
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['remote_criteria_type'] = 'contains';
        $view->vars['remote_criteria_name'] = 'phrase';
        $view->vars['media_type'] = $options['media_type'];
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_media_autocomplete_choice';
    }

    public function getParent(): string
    {
        return ResourceAutocompleteChoiceType::class;
    }
}
