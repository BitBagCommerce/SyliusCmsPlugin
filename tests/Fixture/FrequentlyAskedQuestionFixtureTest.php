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

use BitBag\CmsPlugin\Fixture\FrequentlyAskedQuestionFixture;
use BitBag\CmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class FrequentlyAskedQuestionFixtureTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     */
    public function frequently_asked_questions_are_optional(): void
    {
        $this->assertConfigurationIsValid([[]], 'frequently_asked_questions');
    }

    /**
     * @test
     */
    public function frequently_asked_questions_enabled_is_optional_but_must_be_boolean(): void
    {
        $this->assertConfigurationIsValid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'enabled' => true
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.enabled');

        $this->assertPartialConfigurationIsInvalid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'enabled' => 'boolean'
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.enabled');
    }

    /**
     * @test
     */
    public function frequently_asked_questions_position_is_optional_but_must_be_integer(): void
    {
        $this->assertConfigurationIsValid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'position' => 1
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.position');

        $this->assertPartialConfigurationIsInvalid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'position' => '1'
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.position');
    }

    /**
     * @test
     */
    public function frequently_asked_questions_translations_is_optional_but_must_be_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'translations' => []
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.translations');

        $this->assertPartialConfigurationIsInvalid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'translations' => 'array'
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.translations');
    }

    /**
     * @test
     */
    public function frequently_asked_questions_may_contain_question(): void
    {
        $this->assertConfigurationIsValid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'translations' => [
                            'en_US' => [
                                'question' => 'Example question ?'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.translations.*.question');

        $this->assertConfigurationIsValid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'translations' => [
                            'en_US' => [
                                'question' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.translations.*.question');
    }

    /**
     * @test
     */
    public function frequently_asked_questions_may_contain_answer(): void
    {
        $this->assertConfigurationIsValid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'translations' => [
                            'en_US' => [
                                'answer' => 'Example answer'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.translations.*.answer');

        $this->assertConfigurationIsValid([
            [
                'frequently_asked_questions' => [
                    'faq_1' => [
                        'translations' => [
                            'en_US' => [
                                'answer' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'frequently_asked_questions.*.translations.*.answer');
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration(): FrequentlyAskedQuestionFixture
    {
        /** @var FactoryInterface $frequentlyAskedQuestionFactory */
        $frequentlyAskedQuestionFactory = $this->getMockBuilder(FactoryInterface::class)->getMock();
        /** @var FactoryInterface $frequentlyAskedQuestionFactoryTranslation */
        $frequentlyAskedQuestionFactoryTranslation = $this->getMockBuilder(FactoryInterface::class)->getMock();
        /** @var FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository */
        $frequentlyAskedQuestionRepository = $this->getMockBuilder(FrequentlyAskedQuestionRepositoryInterface::class)->getMock();

        return new FrequentlyAskedQuestionFixture(
            $frequentlyAskedQuestionFactory,
            $frequentlyAskedQuestionFactoryTranslation,
            $frequentlyAskedQuestionRepository
        );
    }
}
