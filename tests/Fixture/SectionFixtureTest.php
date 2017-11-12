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

use BitBag\CmsPlugin\Fixture\SectionFixture;
use BitBag\CmsPlugin\Repository\SectionRepositoryInterface;
use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use Sylius\Component\Resource\Factory\FactoryInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class SectionFixtureTest extends \PHPUnit_Framework_TestCase
{
    use ConfigurationTestCaseTrait;

    /**
     * @test
     */
    public function sections_are_optional(): void
    {
        $this->assertConfigurationIsValid([[]], 'sections');
    }

    /**
     * @test
     */
    public function sections_translations_is_optional_but_must_be_array(): void
    {
        $this->assertConfigurationIsValid([
            [
                'sections' => [
                    'blog' => [
                        'translations' => []
                    ]
                ]
            ]
        ], 'sections.*.translations');

        $this->assertPartialConfigurationIsInvalid([
            [
                'sections' => [
                    'blog' => [
                        'translations' => 'array'
                    ]
                ]
            ]
        ], 'sections.*.translations');
    }

    /**
     * @test
     */
    public function sections_may_contain_name(): void
    {
        $this->assertConfigurationIsValid([
            [
                'sections' => [
                    'blog' => [
                        'translations' => [
                            'en_US' => [
                                'name' => 'Blog'
                            ]
                        ]
                    ]
                ]
            ]
        ], 'sections.*.translations.*.name');

        $this->assertConfigurationIsValid([
            [
                'sections' => [
                    'blog' => [
                        'translations' => [
                            'en_US' => [
                                'name' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ], 'sections.*.translations.*.name');
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration(): SectionFixture
    {
        /** @var FactoryInterface $sectionFactory */
        $sectionFactory = $this->getMockBuilder(FactoryInterface::class)->getMock();
        /** @var FactoryInterface $sectionTranslationFactory */
        $sectionTranslationFactory = $this->getMockBuilder(FactoryInterface::class)->getMock();
        /** @var SectionRepositoryInterface $sectionRepository */
        $sectionRepository = $this->getMockBuilder(SectionRepositoryInterface::class)->getMock();

        return new SectionFixture(
            $sectionFactory,
            $sectionTranslationFactory,
            $sectionRepository
        );
    }
}
