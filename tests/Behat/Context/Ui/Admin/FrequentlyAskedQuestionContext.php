<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\FrequentlyAskedQuestion\CreatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\FrequentlyAskedQuestion\IndexPageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\FrequentlyAskedQuestion\UpdatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;
use Webmozart\Assert\Assert;

final class FrequentlyAskedQuestionContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var CurrentPageResolverInterface */
    private $currentPageResolver;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    /** @var IndexPageInterface */
    private $indexPage;

    /** @var CreatePageInterface */
    private $createPage;

    /** @var UpdatePageInterface */
    private $updatePage;

    /** @var RandomStringGeneratorInterface */
    private $randomStringGenerator;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        RandomStringGeneratorInterface $randomStringGenerator,
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->randomStringGenerator = $randomStringGenerator;
    }

    /**
     * @When I go to the frequently asked questions page
     */
    public function iGoToTheFrequentlyAskedQuestionsPage(): void
    {
        $this->indexPage->open();
    }

    /**
     * @When I go to the create frequently asked question page
     */
    public function iGoToTheCreateFrequentlyAskedQuestionPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I want to edit this frequently asked question
     */
    public function iWantToEditThisFrequentlyAskedQuestion(): void
    {
        $frequentlyAskedQuestion = $this->sharedStorage->get('frequently_asked_question');

        $this->updatePage->open(['id' => $frequentlyAskedQuestion->getId()]);
    }

    /**
     * @When I delete this frequently asked question
     */
    public function iDeleteThisFrequentlyAskedQuestion()
    {
        $frequentlyAskedQuestion = $this->sharedStorage->get('frequently_asked_question');

        $this->indexPage->deleteFrequentlyAskedQuestion($frequentlyAskedQuestion->getCode());
    }

    /**
     * @When I fill the code with :code
     */
    public function iFillTheCodeWith(string $code): void
    {
        $this->createPage->fillCode($code);
    }

    /**
     * @When I set the position to :position
     */
    public function iSetThePositionTo(int $position): void
    {
        $this->createPage->setPosition($position);
    }

    /**
     * @When I fill the question with :question
     */
    public function iFillTheQuestionWith(string $question): void
    {
        $this->createPage->fillQuestion($question);
    }

    /**
     * @When I set the answer to :answer
     */
    public function iSetTheAnswerTo(string $answer): void
    {
        $this->createPage->fillAnswer($answer);
    }

    /**
     * @When /^I fill "([^"]*)" fields with (\d+) (?:character|characters)$/
     */
    public function iFillFieldsWithCharacters(string $fields, int $length): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            $this->resolveCurrentPage()->fillField(trim($field), $this->randomStringGenerator->generate($length));
        }
    }

    /**
     * @When I add it
     * @When I try to add it
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @Then I should be notified that a new frequently asked question has been created
     */
    public function iShouldBeNotifiedThatANewFrequentlyAskedQuestionHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Success Frequently asked question has been successfully created.',
            NotificationType::success(),
        );
    }

    /**
     * @Then I should be notified that the fequently asked question has been deleted
     */
    public function iShouldBeNotifiedThatTheFrequentlyAskedQuestionHasBeenDeleted(): void
    {
        $this->notificationChecker->checkNotification(
            'Frequently asked question has been successfully deleted.',
            NotificationType::success(),
        );
    }

    /**
     * @Then I should be notified that :fields fields cannot be blank
     */
    public function iShouldBeNotifiedThatFieldsCannotBeBlank(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                '%s cannot be blank.',
                trim($field),
            )));
        }
    }

    /**
     * @Then I should be notified that :fields fields are too short
     */
    public function iShouldBeNotifiedThatFieldsAreTooShort(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                '%s must be at least %d characters long.',
                trim($field),
                2,
            )));
        }
    }

    /**
     * @Then I should be notified that there is already an existing frequently asked question with provided code
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingFrequentlyAskedQuestionWithProvidedCode(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing FAQ with this code.',
            false,
        ));
    }

    /**
     * @Then I should be notified that there is already an existing frequently asked question with selected position
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingFrequentlyAskedQuestionWithSelectedPosition(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing FAQ with this position.',
            false,
        ));
    }

    /**
     * @Then the code field should be disabled
     */
    public function theCodeFieldShouldBeDisabled()
    {
        Assert::true($this->resolveCurrentPage()->isCodeDisabled());
    }

    /**
     * @Then I should see empty list of frequently asked questions
     */
    public function iShouldSeeEmptyListOfFrequentlyAskedQuestions(): void
    {
        $this->resolveCurrentPage()->isEmpty();
    }

    /**
     * @return IndexPageInterface|CreatePageInterface|UpdatePageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->indexPage,
            $this->createPage,
            $this->updatePage,
        ]);
    }
}
