<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class SectionFixtureFactory implements FixtureFactoryInterface
{
    public function __construct(
        private FactoryInterface $sectionFactory,
        private FactoryInterface $sectionTranslationFactory,
        private SectionRepositoryInterface $sectionRepository,
    ) {
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            /** @var ?SectionInterface $section */
            $section = $this->sectionRepository->findOneBy(['code' => $code]);
            if (
                true === $fields['remove_existing'] &&
                null !== $section
            ) {
                $this->sectionRepository->remove($section);
            }

            /** @var SectionInterface $section */
            $section = $this->sectionFactory->createNew();

            $section->setCode($code);

            foreach ($fields['translations'] as $localeCode => $translation) {
                /** @var SectionTranslationInterface $sectionTranslation */
                $sectionTranslation = $this->sectionTranslationFactory->createNew();

                $sectionTranslation->setLocale($localeCode);
                $sectionTranslation->setName($translation['name']);

                $section->addTranslation($sectionTranslation);
            }

            $this->sectionRepository->add($section);
        }
    }
}
