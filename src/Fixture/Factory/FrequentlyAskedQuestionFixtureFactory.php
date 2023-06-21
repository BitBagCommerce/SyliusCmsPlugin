<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class FrequentlyAskedQuestionFixtureFactory implements FixtureFactoryInterface
{
    public function __construct(
        private FactoryInterface $frequentlyAskedQuestionFactory,
        private FactoryInterface $frequentlyAskedQuestionTranslationFactory,
        private FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository,
        private ChannelsAssignerInterface $channelAssigner,
        ) {
    }

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
                for ($i = 1; $i <= $fields['number']; ++$i) {
                    $this->createFrequentlyAskedQuestion(md5(uniqid()), $fields, $i);
                }
            } else {
                $this->createFrequentlyAskedQuestion($code, $fields, $fields['position']);
            }
        }
    }

    private function createFrequentlyAskedQuestion(
        string $code,
        array $frequentlyAskedQuestionData,
        int $position,
        ): void {
        /** @var FrequentlyAskedQuestionInterface $frequentlyAskedQuestion */
        $frequentlyAskedQuestion = $this->frequentlyAskedQuestionFactory->createNew();

        $frequentlyAskedQuestion->setCode($code);
        $frequentlyAskedQuestion->setEnabled($frequentlyAskedQuestionData['enabled']);
        $frequentlyAskedQuestion->setPosition($position);

        $this->channelAssigner->assign($frequentlyAskedQuestion, $frequentlyAskedQuestionData['channels']);

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
