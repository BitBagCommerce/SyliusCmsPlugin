<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Fixture;

use BitBag\CmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use BitBag\CmsPlugin\Entity\FrequentlyAskedQuestionTranslationInterface;
use BitBag\CmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class FrequentlyAskedQuestionFixture extends AbstractFixture implements FixtureInterface
{
    /**
     * @var FactoryInterface
     */
    private $frequentlyAskedQuestionFactory;

    /**
     * @var FactoryInterface
     */
    private $frequentlyAskedQuestionTranslationFactory;

    /**
     * @var FrequentlyAskedQuestionRepositoryInterface
     */
    private $frequentlyAskedQuestionRepository;

    /**
     * @param FactoryInterface $frequentlyAskedQuestionFactory
     * @param FactoryInterface $frequentlyAskedQuestionTranslationFactory
     * @param FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository
     */
    public function __construct(
        FactoryInterface $frequentlyAskedQuestionFactory,
        FactoryInterface $frequentlyAskedQuestionTranslationFactory,
        FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository
    )
    {
        $this->frequentlyAskedQuestionFactory = $frequentlyAskedQuestionFactory;
        $this->frequentlyAskedQuestionTranslationFactory = $frequentlyAskedQuestionTranslationFactory;
        $this->frequentlyAskedQuestionRepository = $frequentlyAskedQuestionRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $options): void
    {
        foreach ($options['frequently_asked_questions'] as $code => $fields) {

            if (null !== $this->frequentlyAskedQuestionRepository->findOneBy(['code' => $code])) {
                continue;
            }

            /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
            $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();

            $frequentlyAskedQuestion->setCode($code);
            $frequentlyAskedQuestion->setEnabled($fields['enabled']);
            $frequentlyAskedQuestion->setPosition($fields['position']);

            foreach ($fields['translations'] as $localeCode => $translation) {
                /** @var FrequentlyAskedQuestionTranslationInterface $frequentlyAskedQuestionTranslation */
                $frequentlyAskedQuestionTranslation = $this->frequentlyAskedQuestionFactory->createNew();

                $frequentlyAskedQuestionTranslation->setLocale($localeCode);
                $frequentlyAskedQuestionTranslation->setQuestion($translation['question']);
                $frequentlyAskedQuestionTranslation->setAnswer($translation['answer']);

                $frequentlyAskedQuestion->addTranslation($frequentlyAskedQuestionTranslation);
            }

            $this->frequentlyAskedQuestionRepository->add($frequentlyAskedQuestion);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'bitbag_cms_frequently_asked_question';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
                ->arrayNode('frequently_asked_questions')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('enabled')->defaultTrue()->end()
                            ->scalarNode('position')->defaultNull()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('question')->defaultNull()->end()
                                        ->scalarNode('answer')->defaultNull()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
