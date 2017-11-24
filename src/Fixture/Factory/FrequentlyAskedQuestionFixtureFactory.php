<?php

/**
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class FrequentlyAskedQuestionFixtureFactory implements FixtureFactoryInterface
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
    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $frequentlyAskedQuestion = $this->frequentlyAskedQuestionRepository->findOneBy(['code' => $code])
            ) {
                $this->frequentlyAskedQuestionRepository->remove($frequentlyAskedQuestion);
            }

            if (null !== $fields['number']) {
                for ($i = 1; $i <= $fields['number']; $i++) {
                    $this->createFrequentlyAskedQuestion(md5(uniqid()), $fields, $i);
                }
            } else {
                $this->createFrequentlyAskedQuestion($code, $fields, $fields['position']);
            }
        }
    }

    /**
     * @param string $code
     * @param array $frequentlyAskedQuestionData
     * @param int $position
     */
    private function createFrequentlyAskedQuestion(string $code, array $frequentlyAskedQuestionData, int $position): void
    {
        /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
        $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();

        $frequentlyAskedQuestion->setCode($code);
        $frequentlyAskedQuestion->setEnabled($frequentlyAskedQuestionData['enabled']);
        $frequentlyAskedQuestion->setPosition($position);

        foreach ($frequentlyAskedQuestionData['translations'] as $localeCode => $translation) {
            /** @var FrequentlyAskedQuestionTranslationInterface $frequentlyAskedQuestionTranslation */
            $frequentlyAskedQuestionTranslation = $this->frequentlyAskedQuestionTranslationFactory->createNew();

            $frequentlyAskedQuestionTranslation->setLocale($localeCode);
            $frequentlyAskedQuestionTranslation->setQuestion($translation['question']);
            $frequentlyAskedQuestionTranslation->setAnswer($translation['answer']);

            $frequentlyAskedQuestion->addTranslation($frequentlyAskedQuestionTranslation);
        }

        $this->frequentlyAskedQuestionRepository->add($frequentlyAskedQuestion);
    }
}
