<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Functional\Fixture;

use BitBag\SyliusCmsPlugin\Fixture\BlockFixture;
use BitBag\SyliusCmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;

final class BlockFixtureTest extends TestCase
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
                       'enabled' => true,
                    ],
                ],
            ],
        ], 'custom.*.enabled');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'enabled' => 'boolean',
                    ],
                ],
            ],
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
    public function custom_collections_is_optional_but_must_be_scalar_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'collections' => ['blog', 'homepage'],
                    ],
                ],
            ],
        ], 'custom.*.collections');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'homepage_banner' => [
                        'collections' => [],
                    ],
                ],
            ],
        ], 'custom.*.collections');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'collections' => '',
                    ],
                ],
            ],
        ], 'custom.*.collections');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'custom_1' => [
                        'collection_name' => 'blog',
                    ],
                ],
            ],
        ], 'custom.*.collections');
    }

    protected function getConfiguration(): BlockFixture
    {
        /** @var FixtureFactoryInterface $blockFixtureFactory */
        $blockFixtureFactory = $this->getMockBuilder(FixtureFactoryInterface::class)->getMock();

        return new BlockFixture($blockFixtureFactory);
    }
}
