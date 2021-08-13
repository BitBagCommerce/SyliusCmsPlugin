<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Fixture;

use BitBag\SyliusCmsPlugin\Fixture\Factory\FixtureFactoryInterface;
use BitBag\SyliusCmsPlugin\Fixture\FrequentlyAskedQuestionFixture;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;

final class FrequentlyAskedQuestionFixtureTest extends TestCase
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
                    'faq_1' => [
                        'enabled' => true,
                    ],
                ],
            ],
        ], 'custom.*.enabled');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'faq_1' => [
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
                    'faq_1' => [
                        'remove_existing' => true,
                    ],
                ],
            ],
        ], 'custom.*.remove_existing');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'faq_1' => [
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
    public function custom_position_is_optional_but_must_be_integer(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'faq_1' => [
                        'position' => 1,
                    ],
                ],
            ],
        ], 'custom.*.position');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'faq_1' => [
                        'position' => '1',
                    ],
                ],
            ],
        ], 'custom.*.position');
    }

    /**
     * @test
     */
    public function custom_translations_is_optional_but_must_be_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'faq_1' => [
                        'translations' => [],
                    ],
                ],
            ],
        ], 'custom.*.translations');

        $this->assertPartialConfigurationIsInvalid([
            [
                'custom' => [
                    'faq_1' => [
                        'translations' => 'array',
                    ],
                ],
            ],
        ], 'custom.*.translations');
    }

    /**
     * @test
     */
    public function custom_may_contain_question(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'faq_1' => [
                        'translations' => [
                            'en_US' => [
                                'question' => 'Example question ?',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.question');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'faq_1' => [
                        'translations' => [
                            'en_US' => [
                                'question' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.question');
    }

    /**
     * @test
     */
    public function custom_may_contain_answer(): void
    {
        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'faq_1' => [
                        'translations' => [
                            'en_US' => [
                                'answer' => 'Example answer',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.answer');

        $this->assertConfigurationIsValid([
            [
                'custom' => [
                    'faq_1' => [
                        'translations' => [
                            'en_US' => [
                                'answer' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ], 'custom.*.translations.*.answer');
    }

    protected function getConfiguration(): FrequentlyAskedQuestionFixture
    {
        /** @var FixtureFactoryInterface $faqFixtureFactory */
        $faqFixtureFactory = $this->getMockBuilder(FixtureFactoryInterface::class)->getMock();

        return new FrequentlyAskedQuestionFixture($faqFixtureFactory);
    }
}
