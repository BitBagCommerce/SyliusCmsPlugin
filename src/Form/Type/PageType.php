<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Sylius\CmsPlugin\Form\Type\Translation\PageTranslationType;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class PageType extends AbstractResourceType
{
    private array $locales = [];

    public function __construct(
        private RepositoryInterface $localeRepository,
        string $dataClass,
        array $validationGroups = [],
    ) {
        parent::__construct($dataClass, $validationGroups);

        /** @var LocaleInterface[] $locales */
        $locales = $this->localeRepository->findAll();
        foreach ($locales as $locale) {
            $this->locales[$locale->getName()] = $locale->getCode();
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'sylius_cms.ui.code',
                'disabled' => null !== $builder->getData()->getCode(),
            ])
            ->add('name', TextType::class, [
                'label' => 'sylius_cms.ui.name',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius_cms.ui.enabled',
            ])
            ->add('translations', ResourceTranslationsType::class, [
                'label' => 'sylius_cms.ui.images',
                'entry_type' => PageTranslationType::class,
            ])
            ->add('collections', CollectionAutocompleteChoiceType::class, [
                'label' => 'sylius_cms.ui.collections',
                'multiple' => true,
            ])
            ->add('channels', ChannelChoiceType::class, [
                'label' => 'sylius_cms.ui.channels',
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('publishAt', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'label' => 'sylius_cms.ui.publish_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
            ->add('contentElements', CollectionType::class, [
                'label' => false,
                'entry_type' => ContentConfigurationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
                'entry_options' => [
                    'label' => false,
                ],
                'attr' => [
                    'class' => 'content-elements-container',
                ],
            ])
            ->add('template', TemplatePageAutocompleteChoiceType::class, [
                'label' => false,
                'mapped' => false,
            ])
            ->add('locale', ChoiceType::class, [
                'choices' => $this->locales,
                'mapped' => false,
                'label' => 'sylius.ui.locale',
                'attr' => [
                    'class' => 'locale-selector',
                ]
            ])
        ;

        self::addContentElementLocaleListener($builder);
    }

    public static function addContentElementLocaleListener(FormBuilderInterface $builder): void
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $selectedLocale = $data['locale'] ?? null;

            if (isset($data['contentElements'])) {
                foreach ($data['contentElements'] as &$contentElement) {
                    if (empty($contentElement['locale'])) {
                        $contentElement['locale'] = $selectedLocale;
                    }
                }
            }

            $event->setData($data);
        });
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_cms_page';
    }
}
