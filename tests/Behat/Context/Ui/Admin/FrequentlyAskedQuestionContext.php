<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Tests\BitBag\CmsPlugin\Behat\Behaviour\ContainsError;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\FrequentlyAskedQuestion\CreatePageInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class FrequentlyAskedQuestionContext implements Context
{
    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;

    /**
     * @var CurrentPageResolverInterface
     */
    private $currentPageResolver;

    /**
     * @var CreatePageInterface
     */
    private $createPage;

    /**
     * @param NotificationCheckerInterface $notificationChecker
     * @param CurrentPageResolverInterface $currentPageResolver
     * @param CreatePageInterface $createPage
     */
    public function __construct(
        NotificationCheckerInterface $notificationChecker,
        CurrentPageResolverInterface $currentPageResolver,
        CreatePageInterface $createPage
    )
    {
        $this->notificationChecker = $notificationChecker;
        $this->currentPageResolver = $currentPageResolver;
        $this->createPage = $createPage;
    }

    /**
     * @When I go to the create faq page
     */
    public function iGoToTheCreateFaqPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I fill code with :code
     */
    public function iFillCodeWith(string $code): void
    {
        $this->createPage->fillCode($code);
    }

    /**
     * @When I set the position to :position
     *
     * @param int $position
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
     * @When I add it
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @Then I should be notified that a new faq has been created
     */
    public function iShouldBeNotifiedThatANewFaqHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Success Frequently asked question has been successfully created.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that :fields can not be blank
     */
    public function iShouldBeNotifiedThatCanNotBeBlank(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                "%s can not be blank.",
                trim($field)
            )));
        }
    }

    /**
     * @Then I should be notified that there is already an existing faq with selected position
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingFaqWithSelectedPosition(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            "There is an existing faq with this position.",
            false
        ));
    }

    /**
     * @return SymfonyPageInterface|CreatePageInterface|ContainsError
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([
            $this->createPage,
        ]);
    }
}