<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;

final class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', FileType::class, [
            'required' => true,
            'constraints' => [
                new NotNull([
                    'message' => 'bitbag_sylius_cms_plugin.import.not_blank',
                ]),
                new File([
                    'mimeTypes' => ['text/csv', 'text/plain'],
                    'mimeTypesMessage' => 'bitbag_sylius_cms_plugin.import.invalid_format',
                ]),
            ],
        ]);
    }
}
