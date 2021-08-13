<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Fixture;

use BitBag\SyliusCmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use BitBag\SyliusCmsPlugin\Fixture\MediaFixture;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;

final class MediaFixtureTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     */
    public function custom_are_optional(): void
    {
        $this->assertConfigurationIsValid([[]], 'custom');
    }

    /**
     * @test
     */
    public function custom_enabled_is_optional_but_must_be_boolean(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_1' => [
                        'enabled' => true,
                    ],
                ],
            ],
        ], 'custom.*.enabled');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'media_1' => [
                        'enabled' => 'boolean',
                    ],
                ],
            ],
        ], 'custom.*.enabled');
    }

    /**
     * @test
     */
    public function custom_translations_is_optional_but_must_be_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_1' => [
                        'translations' => [],
                    ],
                ],
            ],
        ], 'custom.*.translations');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'media_1' => [
                        'translations' => 'array',
                    ],
                ],
            ],
        ], 'custom.*.translations');
    }

    /**
     * @test
     */
    public function custom_may_contain_alt(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_1' => [
                        'translations' => [
                            'en_US' => [
                                'alt' => 'my-media',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.alt');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_1' => [
                        'translations' => [
                            'en_US' => [
                                'alt' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.alt');
    }

    /**
     * @test
     */
    public function custom_may_contain_name(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_1' => [
                        'translations' => [
                            'en_US' => [
                                'name' => 'My media',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.name');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_1' => [
                        'translations' => [
                            'en_US' => [
                                'name' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.name');
    }

    /**
     * @test
     */
    public function custom_may_contain_content(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_1' => [
                        'translations' => [
                            'en_US' => [
                                'content' => 'My media',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.content');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_1' => [
                        'translations' => [
                            'en_US' => [
                                'content' => 'My media',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.content');
    }

    /**
     * @test
     */
    public function custom_number_is_optional_but_must_be_integer(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_banner' => [
                        'number' => 1,
                    ],
                ],
            ],
        ], 'custom.*.number');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'media_banner' => [
                        'number' => '1',
                    ],
                ],
            ],
        ], 'custom.*.number');
    }

    /**
     * @test
     */
    public function custom_remove_existing_is_optional_but_must_be_boolean(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_banner' => [
                        'remove_existing' => true,
                    ],
                ],
            ],
        ], 'custom.*.remove_existing');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'media_banner' => [
                        'remove_existing' => 'boolean',
                    ],
                ],
            ],
        ], 'custom.*.remove_existing');
    }

    /**
     * @test
     */
    public function custom_sections_is_optional_but_must_be_scalar_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_banner' => [
                        'sections' => ['blog', 'media'],
                    ],
                ],
            ],
        ], 'custom.*.sections');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_banner' => [
                        'sections' => [],
                    ],
                ],
            ],
        ], 'custom.*.sections');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'sections' => '',
                    ],
                ],
            ],
        ], 'custom.*.sections');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'section_name' => 'blog',
                    ],
                ],
            ],
        ], 'custom.*.sections');
    }

    /**
     * @test
     */
    public function custom_products_is_optional_but_must_be_scalar_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_banner' => [
                        'productCodes' => ['mug', 't-shirt'],
                    ],
                ],
            ],
        ], 'custom.*.productCodes');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'media_banner' => [
                        'productCodes' => [],
                    ],
                ],
            ],
        ], 'custom.*.productCodes');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'productCodes' => '',
                    ],
                ],
            ],
        ], 'custom.*.productCodes');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'product_name' => 'mug',
                    ],
                ],
            ],
        ], 'custom.*.productCodes');
    }

    protected function getConfiguration(): MediaFixture
    {
        /** @var FixtureFactoryInterface $mediaFixtureFactory */
        $mediaFixtureFactory = $this->getMockBuilder(FixtureFactoryInterface::class)->getMock();

        return new MediaFixture($mediaFixtureFactory);
    }
}
