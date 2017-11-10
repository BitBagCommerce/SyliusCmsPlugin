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

use BitBag\CmsPlugin\Entity\PageInterface;
use BitBag\CmsPlugin\Entity\PageTranslationInterface;
use BitBag\CmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class PageFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * @var FactoryInterface
     */
    private $pageFactory;

    /**
     * @var FactoryInterface
     */
    private $pageTranslationFactory;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @param FactoryInterface $pageFactory
     * @param FactoryInterface $pageTranslationFactory
     * @param PageRepositoryInterface $pageRepository
     */
    public function __construct(
        FactoryInterface $pageFactory,
        FactoryInterface $pageTranslationFactory,
        PageRepositoryInterface $pageRepository
    )
    {
        $this->pageFactory = $pageFactory;
        $this->pageTranslationFactory = $pageTranslationFactory;
        $this->pageRepository = $pageRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $options): void
    {
        foreach ($options['pages'] as $code => $fields) {

            if (null !== $this->pageRepository->findOneBy(['code' => $code])) {
                continue;
            }

            /** @var PageInterface $page */
            $page = $this->pageFactory->createNew();

            $page->setCode($code);
            $page->setEnabled($fields['enabled']);

            foreach ($fields['translations'] as $localeCode => $translation) {
                /** @var PageTranslationInterface $pageTranslation */
                $pageTranslation = $this->pageTranslationFactory->createNew();

                $pageTranslation->setLocale($localeCode);
                $pageTranslation->setSlug($translation['slug']);
                $pageTranslation->setName($translation['name']);
                $pageTranslation->setMetaKeywords($translation['meta_keywords']);
                $pageTranslation->setMetaDescription($translation['meta_description']);
                $pageTranslation->setContent($translation['content']);

                $page->addTranslation($pageTranslation);
            }

            $this->pageRepository->add($page);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'bitbag_cms_page';
    }

    /**
     * {@inheritDoc}
     */
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('pages')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('enabled')->defaultTrue()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('slug')->defaultNull()->end()
                                        ->scalarNode('name')->defaultNull()->end()
                                        ->scalarNode('meta_keywords')->defaultNull()->end()
                                        ->scalarNode('meta_description')->defaultNull()->end()
                                        ->scalarNode('content')->defaultNull()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
