<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use BitBag\SyliusCmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Twig\Environment;

final class ContentConfigurationType extends AbstractResourceType
{
    private array $actionTypes = [];

    private array $actionConfigurationTypes;

    public function __construct(
        string $dataClass,
        array $validationGroups,
        iterable $actionConfigurationTypes,
        private Environment $twig,
    ) {
        parent::__construct($dataClass, $validationGroups);

        foreach ($actionConfigurationTypes as $type => $formType) {
            $this->actionConfigurationTypes[$type] = $formType::class;
            $this->actionTypes['bitbag_sylius_cms_plugin.ui.content_elements.type.' . $type] = $type;
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $defaultActionType = current($this->actionTypes);
        $defaultActionConfigurationType = $this->actionConfigurationTypes[$defaultActionType];

        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'sylius.ui.type',
                'choices' => $this->actionTypes,
                'choice_attr' => function (?string $type) use ($builder): array {
                    return [
                        'data-configuration' => $this->twig->render(
                            '@BitBagSyliusCmsPlugin/ContentConfiguration/_action.html.twig',
                            [
                                'field' => $builder->create(
                                    'configuration',
                                    $this->actionConfigurationTypes[$type],
                                    [
                                        'label' => false,
                                        'csrf_protection' => false,
                                    ],
                                )->getForm()->createView(),
                            ],
                        ),
                    ];
                },
            ])
            ->add('configuration', $defaultActionConfigurationType, [
                'label' => false,
            ])
        ;

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
                $this->addConfigurationTypeToForm($event);
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event): void {
                /** @var array|null $data */
                $data = $event->getData();
                if (null === $data) {
                    return;
                }

                $form = $event->getForm();
                $formData = $form->getData();

                if (null !== $formData && $formData->getType() !== $data['type']) {
                    $formData->setConfiguration([]);
                }

                $this->addConfigurationTypeToForm($event);
            })
        ;
    }

    private function addConfigurationTypeToForm(FormEvent $event): void
    {
        $data = $event->getData();
        if (null === $data) {
            return;
        }

        $form = $event->getForm();

        $dataType = $data instanceof ContentConfigurationInterface ? $data->getType() : $data['type'];

        $actionConfigurationType = $this->actionConfigurationTypes[$dataType];
        $form->add('configuration', $actionConfigurationType, [
            'label' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_content_configuration';
    }
}
