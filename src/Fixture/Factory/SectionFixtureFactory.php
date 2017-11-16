<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class SectionFixtureFactory implements FixtureFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $sectionFactory;

    /**
     * @var FactoryInterface
     */
    private $sectionTranslationFactory;

    /**
     * @var SectionRepositoryInterface
     */
    private $sectionRepository;

    /**
     * @param FactoryInterface $sectionFactory
     * @param FactoryInterface $sectionTranslationFactory
     * @param SectionRepositoryInterface $sectionRepository
     */
    public function __construct(
        FactoryInterface $sectionFactory,
        FactoryInterface $sectionTranslationFactory,
        SectionRepositoryInterface $sectionRepository
    )
    {
        $this->sectionFactory = $sectionFactory;
        $this->sectionTranslationFactory = $sectionTranslationFactory;
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $section = $this->sectionRepository->findOneBy(['code' => $code])
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

