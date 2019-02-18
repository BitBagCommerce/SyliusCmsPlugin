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

use BitBag\SyliusCmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use BitBag\SyliusCmsPlugin\Fixture\PageFixture;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;

final class PageFixtureTest extends TestCase
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
                    'page_1' => [
                        'enabled' => true,
                    ],
                ],
            ],
        ], 'custom.*.enabled');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'page_1' => [
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
                    'page_1' => [
                        'translations' => [],
                    ],
                ],
            ],
        ], 'custom.*.translations');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => 'array',
                    ],
                ],
            ],
        ], 'custom.*.translations');
    }

    /**
     * @test
     */
    public function custom_may_contain_slug(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'slug' => 'my-page',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.slug');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'slug' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.slug');
    }

    /**
     * @test
     */
    public function custom_may_contain_name(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'name' => 'My page',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.name');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
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
    public function custom_may_contain_meta_keywords(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'meta_keywords' => 'page',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.meta_keywords');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'meta_keywords' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.meta_keywords');
    }

    /**
     * @test
     */
    public function custom_may_contain_meta_description(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'meta_description' => 'My page',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.meta_description');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'meta_description' => 'My page',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.meta_description');
    }

    /**
     * @test
     */
    public function custom_may_contain_content(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'content' => 'My page',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.content');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'content' => 'My page',
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
                    'homepage_banner' => [
                        'number' => 1,
                    ],
                ],
            ],
        ], 'custom.*.number');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
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
                    'homepage_banner' => [
                        'remove_existing' => true,
                    ],
                ],
            ],
        ], 'custom.*.remove_existing');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
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
                    'homepage_banner' => [
                        'sections' => ['blog', 'homepage'],
                    ],
                ],
            ],
        ], 'custom.*.sections');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
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
    public function custom_products_is_optional_but_must_be_integer(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'products' => 5,
                    ],
                ],
            ],
        ], 'custom.*.products');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'enabled' => 'integer',
                    ],
                ],
            ],
        ], 'custom.*.products');
    }

    /**
     * @test
     */
    public function custom_product_codes_is_optional_but_must_be_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'productCodes' => [],
                    ],
                ],
            ],
        ], 'custom.*.productCodes');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'enabled' => 'integer',
                    ],
                ],
            ],
        ], 'custom.*.productCodes');
    }

    protected function getConfiguration(): PageFixture
    {
        /** @var FixtureFactoryInterface $pageFixtureFactory */
        $pageFixtureFactory = $this->getMockBuilder(FixtureFactoryInterface::class)->getMock();

        return new PageFixture($pageFixtureFactory);
    }
}
