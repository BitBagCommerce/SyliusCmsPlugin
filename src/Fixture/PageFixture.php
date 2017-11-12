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
use BitBag\CmsPlugin\Entity\SectionInterface;
use BitBag\CmsPlugin\Repository\PageRepositoryInterface;
use BitBag\CmsPlugin\Repository\SectionRepositoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
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
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var SectionRepositoryInterface
     */
    private $sectionRepository;

    /**
     * @param FactoryInterface $pageFactory
     * @param FactoryInterface $pageTranslationFactory
     * @param PageRepositoryInterface $pageRepository
     * @param ProductRepositoryInterface $productRepository
     * @param SectionRepositoryInterface $sectionRepository
     */
    public function __construct(
        FactoryInterface $pageFactory,
        FactoryInterface $pageTranslationFactory,
        PageRepositoryInterface $pageRepository,
        ProductRepositoryInterface $productRepository,
        SectionRepositoryInterface $sectionRepository
    )
    {
        $this->pageFactory = $pageFactory;
        $this->pageTranslationFactory = $pageTranslationFactory;
        $this->pageRepository = $pageRepository;
        $this->productRepository = $productRepository;
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
                null !== $page = $this->pageRepository->findOneBy(['code' => $code])
            ) {
                $this->pageRepository->remove($page);
            }

            /** @var PageInterface $page */
            $page = $this->pageFactory->createNew();
            $products = $fields['products'];

            if (null !== $products) {
                $this->resolveProducts($page, $products);
            }

            $this->resolveSections($page, $fields['sections']);

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
                ->arrayNode('custom')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->booleanNode('enabled')->defaultTrue()->end()
                            ->integerNode('products')->defaultNull()->end()
                            ->arrayNode('sections')
                                ->prototype('scalar')->end()
                            ->end()
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
            ->end()
        ;
    }

    /**
     * @param int $limit
     * @param PageInterface $page
     */
    private function resolveProducts(PageInterface $page, int $limit): void
    {
        $products = $this->productRepository->findBy([], null, $limit);

        foreach ($products as $product) {
            $page->addProduct($product);
        }
    }

    /**
     * @param PageInterface $page
     * @param array $sections
     */
    private function resolveSections(PageInterface $page, array $sections): void
    {
        foreach ($sections as $sectionCode) {
            /** @var SectionInterface $section */
            $section = $this->sectionRepository->findOneBy(['code' => $sectionCode]);

            $page->addSection($section);
        }
    }
}
