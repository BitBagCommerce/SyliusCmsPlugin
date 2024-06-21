<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Promotion\Model\CatalogPromotionActionInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class BlockContentType extends AbstractResourceType
{
    private array $actionTypes = [];

    private array $actionConfigurationTypes;

    public function __construct(
        string $dataClass,
        array $validationGroups,
        iterable $actionConfigurationTypes,
    ) {
        parent::__construct($dataClass, $validationGroups);

        foreach ($actionConfigurationTypes as $type => $formType) {
            $this->actionConfigurationTypes[$type] = $formType::class;
            $this->actionTypes['bitbag_sylius_cms_plugin.block_content.action.' . $type] = $type;
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $defaultActionType = current($this->actionTypes);
        $defaultActionConfigurationType = $this->actionConfigurationTypes[$defaultActionType];

        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'sylius.ui.type',
                'choices' => $this->actionTypes,
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

                if ($formData !== null && $formData->getType() !== $data['type']) {
                    $formData->setConfiguration([]);
                }

                $this->addConfigurationTypeToForm($event);
            })
        ;
    }

    private function addConfigurationTypeToForm(FormEvent $event): void
    {
        $data = $event->getData();
        if ($data === null) {
            return;
        }

        $form = $event->getForm();

        $dataType = $data instanceof CatalogPromotionActionInterface ? $data->getType() : $data['type'];

        $actionConfigurationType = $this->actionConfigurationTypes[$dataType];
        $form->add('configuration', $actionConfigurationType, [
            'label' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_block_content';
    }
}
