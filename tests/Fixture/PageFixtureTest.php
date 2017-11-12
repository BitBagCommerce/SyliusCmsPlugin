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

use BitBag\CmsPlugin\Fixture\PageFixture;
use BitBag\CmsPlugin\Repository\PageRepositoryInterface;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class PageFixtureTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     */
    public function pages_are_optional(): void
    {
        $this->assertConfigurationIsValid([[]], 'pages');
    }

    /**
     * @test
     */
    public function pages_enabled_is_optional_but_must_be_boolean(): void
    {
        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'enabled' => true
                    ]
                ]
            ]
        ], 'pages.*.enabled');

        $this->assertPartialConfigurationIsInvalid([
            [
                'pages' => [
                    'page_1' => [
                        'enabled' => 'boolean'
                    ]
                ]
            ]
        ], 'pages.*.enabled');
    }

    /**
     * @test
     */
    public function pages_translations_is_optional_but_must_be_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => []
                    ]
                ]
            ]
        ], 'pages.*.translations');

        $this->assertPartialConfigurationIsInvalid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => 'array'
                    ]
                ]
            ]
        ], 'pages.*.translations');
    }

    /**
     * @test
     */
    public function pages_may_contain_slug(): void
    {
        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'slug' => 'my-page'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.slug');

        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'slug' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.slug');
    }

    /**
     * @test
     */
    public function pages_may_contain_name(): void
    {
        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'name' => 'My page'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.name');

        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'name' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.name');
    }

    /**
     * @test
     */
    public function pages_may_contain_meta_keywords(): void
    {
        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'meta_keywords' => 'page'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.meta_keywords');

        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'meta_keywords' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.meta_keywords');
    }

    /**
     * @test
     */
    public function pages_may_contain_meta_description(): void
    {
        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'meta_description' => 'My page'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.meta_description');

        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'meta_description' => 'My page'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.meta_description');
    }

    /**
     * @test
     */
    public function pages_may_contain_content(): void
    {
        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'content' => 'My page'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.content');

        $this->assertConfigurationIsValid([
            [
                'pages' => [
                    'page_1' => [
                        'translations' => [
                            'en_US' => [
                                'content' => 'My page'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'pages.*.translations.*.content');
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration(): PageFixture
    {
        /** @var FactoryInterface $pageFactory */
        $pageFactory = $this->getMockBuilder(FactoryInterface::class)->getMock();
        /** @var FactoryInterface $pageTranslationFactory */
        $pageTranslationFactory = $this->getMockBuilder(FactoryInterface::class)->getMock();
        /** @var PageRepositoryInterface $pageRepository */
        $pageRepository = $this->getMockBuilder(PageRepositoryInterface::class)->getMock();

        return new PageFixture(
            $pageFactory,
            $pageTranslationFactory,
            $pageRepository
        );
    }
}
