<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Entity\TemplateInterface;
use BitBag\SyliusCmsPlugin\Repository\TemplateRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Helpers\ContentElementHelper;

final class TemplateContext implements Context
{
    public function __construct(
        private FactoryInterface $templateFactory,
        private SharedStorageInterface $sharedStorage,
        private TemplateRepositoryInterface $templateRepository,
    ) {
    }

    /**
     * @Given there is a template in the store with :name name
     * @Given there is a template in the store with :name name and :type type
     */
    public function thereIsATemplate(string $name, ?string $type = null): void
    {
        $template = $this->createTemplate($name, $type);

        $this->saveTemplate($template);
    }

    /**
     * @Given there are :firstContentElement and :secondContentElement content elements in this template
     */
    public function thereAreContentElementsInThisTemplate(string $firstContentElement, string $secondContentElement): void
    {
        /** @var TemplateInterface $template */
        $template = $this->sharedStorage->get('template');
        $template->setContentElements([
            ['type' => ContentElementHelper::getContentElementValueByName($firstContentElement)],
            ['type' => ContentElementHelper::getContentElementValueByName($secondContentElement)],
        ]);

        $this->saveTemplate($template);
    }

    /**
     * @Given there is an existing template named :templateName with :type type that contains :contentElements content elements
     */
    public function thereIsAnExistingTemplateThatContainsContentElements(string $templateName, string $type, string $contentElements): void
    {
        $template = $this->createTemplate($templateName, $type);

        $contentElements = explode(', ', $contentElements);

        $contentElementsArray = [];
        foreach ($contentElements as $contentElement) {
            $contentElementsArray[] = ['type' => ContentElementHelper::getContentElementValueByName($contentElement)];
        }

        $template->setContentElements($contentElementsArray);

        $this->saveTemplate($template);
    }

    private function createTemplate(string $name, ?string $type = null): TemplateInterface
    {
        /** @var TemplateInterface $template */
        $template = $this->templateFactory->createNew();
        $template->setName($name);

        if (null !== $type) {
            $template->setType($type);
        }

        return $template;
    }

    private function saveTemplate(TemplateInterface $template): void
    {
        $this->templateRepository->add($template);
        $this->sharedStorage->set('template', $template);
    }
}
