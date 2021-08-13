<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
