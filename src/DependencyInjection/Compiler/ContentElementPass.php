<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class ContentElementPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds('sylius_cms.content_element') as $id => $attributes) {
            if (!isset($attributes[0]['template'])) {
                throw new \InvalidArgumentException(
                    sprintf('Tagged content element "%s" needs to have `template` attribute.', $id),
                );
            }

            $definition = $container->getDefinition($id);
            $definition->addMethodCall('setTemplate', [$attributes[0]['template']]);
            $definition->addMethodCall('setTwigEnvironment', [new Reference('twig')]);

            if (isset($attributes[0]['form_type'])) {
                $this->registerFormTypeService($container, $attributes[0]['form_type']);
            }
        }
    }

    private function retrieveElementNameConstantFromFormType(string $formType): string
    {
        if (!class_exists($formType)) {
            throw new \InvalidArgumentException(sprintf('Form type "%s" does not exist.', $formType));
        }

        if (!defined($formType . '::TYPE')) {
            throw new \InvalidArgumentException(sprintf('Form type "%s" needs to have "TYPE" constant.', $formType));
        }

        return constant(sprintf('%s::TYPE', $formType));
    }

    private function registerFormTypeService(ContainerBuilder $container, string $formType): void
    {
        $elementName = $this->retrieveElementNameConstantFromFormType($formType);
        $formTypeDefinition = new Definition($formType);
        $formTypeDefinition->addTag('form.type');
        $formTypeDefinition->addTag('sylius_cms.content_elements.type', [
            'key' => $elementName,
        ]);

        $container->setDefinition('sylius_cms.form.type.content_element.' . $elementName, $formTypeDefinition);
    }
}
