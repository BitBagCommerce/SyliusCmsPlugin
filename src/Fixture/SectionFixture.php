<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Fixture;

use BitBag\CmsPlugin\Entity\SectionInterface;
use BitBag\CmsPlugin\Entity\SectionTranslationInterface;
use BitBag\CmsPlugin\Repository\SectionRepositoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class SectionFixture extends AbstractFixture implements FixtureInterface
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
     * {@inheritDoc}
     */
    public function load(array $options): void
    {
        foreach ($options['custom'] as $code => $fields) {
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

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'bitbag_cms_section';
    }

    /**
     * {@inheritDoc}
     */
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('custom')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('name')->defaultNull()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
