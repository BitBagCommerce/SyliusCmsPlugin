<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Page\Shop\FrequentlyAskedQuestion;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class IndexPage extends SymfonyPage implements IndexPageInterface
{
    public function getRouteName(): string
    {
        return 'bitbag_sylius_cms_plugin_shop_frequently_asked_question_index';
    }

    public function hasFrequentlyAskedQuestionsNumber(int $number): bool
    {
        $frequentlyAskedQuestionsOnPage = $this->getElement('faqs')->findAll('css', '.bitbag-question');

        return $number === count($frequentlyAskedQuestionsOnPage);
    }

    public function hasQuestionWithPositionPrefixAtValidIndex(int $position): bool
    {
        $frequentlyAskedQuestionsOnPage = $this->getElement('faqs')->findAll('css', '.bitbag-question');
        $index = $position - 1;

        if (false === array_key_exists($index, $frequentlyAskedQuestionsOnPage)) {
            return false;
        }

        $frequentlyAskedQuestionOnPage = $frequentlyAskedQuestionsOnPage[$index];
        $question = $frequentlyAskedQuestionOnPage->getText();

        $questionParts = explode('. ', $question);
        $positionInQuestion = (int) str_replace('. ', '', $questionParts[0]);

        if ($position === $positionInQuestion) {
            return true;
        }

        return false;
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'faqs' => '#bitbag-faqs',
        ]);
    }
}
