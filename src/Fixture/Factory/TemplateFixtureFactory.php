<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Entity\TemplateInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class TemplateFixtureFactory implements FixtureFactoryInterface
{
    public function __construct(
        private FactoryInterface $templateFactory,
        private RepositoryInterface $templateRepository,
    ) {
    }

    public function load(array $data): void
    {
        foreach ($data as $fields) {
            /** @var ?TemplateInterface $template */
            $template = $this->templateRepository->findOneBy(['name' => $fields['name']]);
            if (
                true === $fields['remove_existing'] &&
                null !== $template
            ) {
                $this->templateRepository->remove($template);
            }

            $this->createPage($fields);
        }
    }

    private function createPage(array $pageData): void
    {
        /** @var TemplateInterface $template */
        $template = $this->templateFactory->createNew();

        $template->setName($pageData['name']);
        $template->setType($pageData['type']);
        $template->setContentElements($pageData['content_elements']);

        $this->templateRepository->add($template);
    }
}
