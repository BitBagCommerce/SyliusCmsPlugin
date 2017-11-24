<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Fixture;

use BitBag\SyliusCmsPlugin\Fixture\BlockFixture;
use BitBag\SyliusCmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;

final class BlockFixtureTest extends \PHPUnit_Framework_TestCase
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
                    'homepage_banner' => [
                       'enabled' => true
                    ]
                ]
            ]
        ], 'custom.*.enabled');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'enabled' => 'boolean'
                    ]
                ]
            ]
        ], 'custom.*.enabled');
    }

    /**
     * @test
     */
    public function custom_remove_existing_is_optional_but_must_be_boolean(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'remove_existing' => true
                    ]
                ]
            ]
        ], 'custom.*.remove_existing');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'remove_existing' => 'boolean'
                    ]
                ]
            ]
        ], 'custom.*.remove_existing');
    }

    /**
     * @test
     */
    public function custom_number_is_optional_but_must_be_integer(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'number' => 1
                    ]
                ]
            ]
        ], 'custom.*.number');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'number' => '1'
                    ]
                ]
            ]
        ], 'custom.*.number');
    }

    /**
     * @test
     */
    public function custom_last_four_products_is_optional_but_must_be_boolean(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'last_four_products' => true
                    ]
                ]
            ]
        ], 'custom.*.last_four_products');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'last_four_products' => 'boolean'
                    ]
                ]
            ]
        ], 'custom.*.last_four_products');
    }

    /**
     * @test
     */
    public function custom_products_is_optional_but_must_be_integer(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                       'products' => 5
                    ]
                ]
            ]
        ], 'custom.*.products');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'enabled' => 'integer'
                    ]
                ]
            ]
        ], 'custom.*.products');
    }

    /**
     * @test
     */
    public function custom_type_is_required_and_cannot_be_empty(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'type' => true
                    ]
                ]
            ]
        ], 'custom.*.type');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'type' => ''
                    ]
                ]
            ]
        ], 'custom.*.type');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => []
                ]
            ]
        ], 'custom.*.type');
    }


    /**
     * @test
     */
    public function custom_translations_is_optional_but_must_be_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'translations' => []
                    ]
                ]
            ]
        ], 'custom.*.translations');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'translations' => ''
                    ]
                ]
            ]
        ], 'custom.*.translations');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'custom_1' => []
                ]
            ]
        ], 'custom.*.translations');
    }

    /**
     * @test
     */
    public function custom_sections_is_optional_but_must_be_scalar_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'sections' => ['blog', 'homepage']
                    ]
                ]
            ]
        ], 'custom.*.sections');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'sections' => []
                    ]
                ]
            ]
        ], 'custom.*.sections');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'sections' => ''
                    ]
                ]
            ]
        ], 'custom.*.sections');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'section_name' => 'blog',
                    ]
                ]
            ]
        ], 'custom.*.sections');
    }

    /**
     * @test
     */
    public function custom_may_contain_name(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'translations' => [
                            'en_US' => [
                                'name' => 'block'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'custom.*.translations.*.name');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'translations' => [
                            'en_US' => [
                                'name' => ''
                            ]
                        ]
                    ]
                ]
            ]
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
                    'homepage_banner' => [
                        'translations' => [
                            'en_US' => [
                                'content' => 'block'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'custom.*.translations.*.content');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'translations' => [
                            'en_US' => [
                                'content' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'custom.*.translations.*.content');
    }

    /**
     * @test
     */
    public function custom_may_contain_link(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'translations' => [
                            'en_US' => [
                                'link' => 'block'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'custom.*.translations.*.link');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'translations' => [
                            'en_US' => [
                                'link' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'custom.*.translations.*.link');
    }

    /**
     * @test
     */
    public function custom_may_contain_image_path(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'translations' => [
                            'en_US' => [
                                'image_path' => '/path/to/img'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'custom.*.translations.*.image_path');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'translations' => [
                            'en_US' => [
                                'image_path' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'custom.*.translations.*.image_path');
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration(): BlockFixture
    {
        /** @var FixtureFactoryInterface $blockFixtureFactory */
        $blockFixtureFactory = $this->getMockBuilder(FixtureFactoryInterface::class)->getMock();

        return new BlockFixture($blockFixtureFactory);
    }
}
