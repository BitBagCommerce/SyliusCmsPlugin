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
use BitBag\SyliusCmsPlugin\Fixture\SectionFixture;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;

final class SectionFixtureTest extends \PHPUnit_Framework_TestCase
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
    public function custom_translations_is_optional_but_must_be_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'blog' => [
                        'translations' => [],
                    ],
                ],
            ],
        ], 'custom.*.translations');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'blog' => [
                        'translations' => 'array',
                    ],
                ],
            ],
        ], 'custom.*.translations');
    }

    /**
     * @test
     */
    public function custom_may_contain_name(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'blog' => [
                        'translations' => [
                            'en_US' => [
                                'name' => 'Blog',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.name');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'blog' => [
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

    protected function getConfiguration(): SectionFixture
    {
        /** @var FixtureFactoryInterface $blockFixtureFactory */
        $blockFixtureFactory = $this->getMockBuilder(FixtureFactoryInterface::class)->getMock();

        return new SectionFixture($blockFixtureFactory);
    }
}
