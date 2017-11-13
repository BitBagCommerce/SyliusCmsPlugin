<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Fixture;

use BitBag\CmsPlugin\Factory\BlockFactoryInterface;
use BitBag\CmsPlugin\Fixture\BlockFixture;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Sylius\Component\Core\Uploader\ImageUploaderInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class BlockFixtureTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     */
    public function blocks_are_optional(): void
    {
        $this->assertConfigurationIsValid([[]], 'blocks');
    }

    /**
     * @test
     */
    public function blocks_enabled_is_optional_but_must_be_boolean(): void
    {
        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                       'enabled' => true
                    ]
                ]
            ]
        ], 'blocks.*.enabled');

        $this->assertPartialConfigurationIsInvalid([
            [
                'blocks' => [
                    'blocks_1' => [
                        'enabled' => 'boolean'
                    ]
                ]
            ]
        ], 'blocks.*.enabled');
    }

    /**
     * @test
     */
    public function blocks_type_is_required_and_cannot_be_empty(): void
    {
        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'type' => true
                    ]
                ]
            ]
        ], 'blocks.*.type');

        $this->assertPartialConfigurationIsInvalid([
            [
                'blocks' => [
                    'blocks_1' => [
                        'type' => ''
                    ]
                ]
            ]
        ], 'blocks.*.type');

        $this->assertPartialConfigurationIsInvalid([
            [
                'blocks' => [
                    'blocks_1' => []
                ]
            ]
        ], 'blocks.*.type');
    }


    /**
     * @test
     */
    public function blocks_translations_is_optional_but_must_be_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'translations' => []
                    ]
                ]
            ]
        ], 'blocks.*.translations');

        $this->assertPartialConfigurationIsInvalid([
            [
                'blocks' => [
                    'blocks_1' => [
                        'translations' => ''
                    ]
                ]
            ]
        ], 'blocks.*.translations');

        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'blocks_1' => []
                ]
            ]
        ], 'blocks.*.translations');
    }

    /**
     * @test
     */
    public function blocks_may_contain_name(): void
    {
        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'translations' => [
                            'en_US' => [
                                'name' => 'block'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'blocks.*.translations.*.name');

        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'translations' => [
                            'en_US' => [
                                'name' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'blocks.*.translations.*.name');
    }

    /**
     * @test
     */
    public function blocks_may_contain_content(): void
    {
        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'translations' => [
                            'en_US' => [
                                'content' => 'block'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'blocks.*.translations.*.content');

        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'translations' => [
                            'en_US' => [
                                'content' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'blocks.*.translations.*.content');
    }

    /**
     * @test
     */
    public function blocks_may_contain_link(): void
    {
        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'translations' => [
                            'en_US' => [
                                'link' => 'block'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'blocks.*.translations.*.link');

        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'translations' => [
                            'en_US' => [
                                'link' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'blocks.*.translations.*.link');
    }

    /**
     * @test
     */
    public function blocks_may_contain_image_path(): void
    {
        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'translations' => [
                            'en_US' => [
                                'image_path' => '/path/to/img'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'blocks.*.translations.*.image_path');

        $this->assertConfigurationIsValid([
            [
                'blocks' => [
                    'block_1' => [
                        'translations' => [
                            'en_US' => [
                                'image_path' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'blocks.*.translations.*.image_path');
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration(): BlockFixture
    {
        /** @var BlockFactoryInterface $blockFactory */
        $blockFactory = $this->getMockBuilder(BlockFactoryInterface::class)->getMock();
        /** @var FactoryInterface $blockTranslationFactory */
        $blockTranslationFactory = $this->getMockBuilder(FactoryInterface::class)->getMock();
        /** @var BlockRepositoryInterface $blockRepository */
        $blockRepository = $this->getMockBuilder(BlockRepositoryInterface::class)->getMock();
        /** @var ImageUploaderInterface $imageUploader */
        $imageUploader = $this->getMockBuilder(ImageUploaderInterface::class)->getMock();

        return new BlockFixture(
            $blockFactory,
            $blockTranslationFactory,
            $blockRepository,
            $imageUploader
        );
    }
}
