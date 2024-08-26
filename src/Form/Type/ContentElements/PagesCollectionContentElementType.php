<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type\ContentElements;

use Sylius\Bundle\ResourceBundle\Form\DataTransformer\ResourceToIdentifierTransformer;
use Sylius\CmsPlugin\Form\Type\PageCollectionAutocompleteChoiceType;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ReversedTransformer;

final class PagesCollectionContentElementType extends AbstractType
{
    public const TYPE = 'pages_collection';

    public function __construct(private RepositoryInterface $collectionRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::TYPE, PageCollectionAutocompleteChoiceType::class, [
                'label' => 'bitbag_sylius_cms_plugin.ui.content_elements.type.' . self::TYPE,
            ])
        ;

        $builder->get(self::TYPE)->addModelTransformer(
            new ReversedTransformer(new ResourceToIdentifierTransformer($this->collectionRepository, 'code')),
        );
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_content_elements_' . self::TYPE;
    }
}
