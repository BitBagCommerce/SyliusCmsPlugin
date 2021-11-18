<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture;

use BitBag\SyliusCmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\BooleanNodeDefinition;
use Symfony\Component\Config\Definition\Builder\IntegerNodeDefinition;
use Symfony\Component\Config\Definition\Builder\ScalarNodeDefinition;

final class BlockFixture extends AbstractFixture
{
    /** @var FixtureFactoryInterface */
    private $blockFixtureFactory;

    public function __construct(FixtureFactoryInterface $blockFixtureFactory)
    {
        $this->blockFixtureFactory = $blockFixtureFactory;
    }

    public function load(array $options): void
    {
        $this->blockFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'block';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {


        $removeExistingNodeDefinition = new BooleanNodeDefinition('remove_existing');
        $removeExistingNodeDefinition->defaultTrue()->end();

        $numberNodeDefinition = new IntegerNodeDefinition('number');
        $numberNodeDefinition->defaultNull()->end();

        $lastFourProductsNodeDefinition = new BooleanNodeDefinition('last_four_products');
        $lastFourProductsNodeDefinition->defaultFalse()->end();

        $enabledNodeDefinition = new BooleanNodeDefinition('enabled');
        $enabledNodeDefinition->defaultTrue()->end();

        $productsNodeDefinition = new IntegerNodeDefinition('products');
        $productsNodeDefinition->defaultNull()->end();

        $productCodesNodeDefinition = new ArrayNodeDefinition('productCodes');
        $productCodesNodeDefinition->scalarPrototype()->end();

        $taxonsNodeDefinition = new ArrayNodeDefinition('taxons');
        $taxonsNodeDefinition->scalarPrototype()->end();

        $sectionsNodeDefinition = new ArrayNodeDefinition('sections');
        $sectionsNodeDefinition->scalarPrototype()->end();

        $channelsNodeDefinition = new ArrayNodeDefinition('channels');
        $channelsNodeDefinition->scalarPrototype()->end();

        $translationsNodeDefinition = new ArrayNodeDefinition('translations');
        $translationsNodeArrayPrototype = $translationsNodeDefinition->arrayPrototype();

        $nameNodeDefinition = new ScalarNodeDefinition('name');
        $nameNodeDefinition->defaultNull()->end();

        $contentNodeDefinition = new ScalarNodeDefinition('content');
        $contentNodeDefinition->defaultNull()->end();

        $linkNodeDefinition = new ScalarNodeDefinition('link');
        $linkNodeDefinition->defaultNull()->end();

        $imagePathNodeDefinition = new ScalarNodeDefinition('image_path');
        $imagePathNodeDefinition->defaultNull()->end();

        $translationsNodeArrayPrototype
            ->append($nameNodeDefinition)
            ->append($contentNodeDefinition)
            ->append($linkNodeDefinition)
            ->append($imagePathNodeDefinition);

        $customNodeDefinition = new ArrayNodeDefinition('custom');
        $generalArrayNodeDefinition = $customNodeDefinition->arrayPrototype();
        $generalArrayNodeDefinition
            ->append($removeExistingNodeDefinition)
            ->append($numberNodeDefinition)
            ->append($lastFourProductsNodeDefinition)
            ->append($enabledNodeDefinition)
            ->append($productsNodeDefinition)
            ->append($productCodesNodeDefinition)
            ->append($taxonsNodeDefinition)
            ->append($sectionsNodeDefinition)
            ->append($channelsNodeDefinition)
            ->append($translationsNodeDefinition);

        $customNodeDefinition->append($generalArrayNodeDefinition);
        $optionsNode->append($customNodeDefinition);
    }
}
