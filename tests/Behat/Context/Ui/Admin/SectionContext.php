<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Section\CreatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Section\IndexPageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Section\UpdatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;
use Webmozart\Assert\Assert;

final class SectionContext implements Context
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
        RandomStringGeneratorInterface $randomStringGenerator
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
     * @When I go to the sections page
     */
    public function iGoToTheSectionsPage(): void
    {
        $this->indexPage->open();
    }

    /**
     * @When I go to the create section page
     */
    public function iGoToTheCreateSectionPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I delete this section
     */
    public function iDeleteThisSection(): void
    {
        $section = $this->sharedStorage->get('section');

        $this->indexPage->deleteSection($section->getCode());
    }

    /**
     * @When I want to edit this section
     */
    public function iWantToEditThisSection(): void
    {
        $section = $this->sharedStorage->get('section');

        $this->updatePage->open(['id' => $section->getId()]);
    }

    /**
     * @When I fill the code with :code
     */
    public function iFillTheCodeWith(string $code): void
    {
        $this->resolveCurrentPage()->fillCode($code);
    }

    /**
     * @When I fill the name with :name
     */
    public function iFillTheNameWith(string $name): void
    {
        $this->resolveCurrentPage()->fillName($name);
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
     * @Then I should be notified that :fields fields cannot be blank
     */
    public function iShouldBeNotifiedThatFieldsCannotBeBlank(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                '%s cannot be blank.',
                trim($field)
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
                trim($field), 2
            )));
        }
    }

    /**
     * @Then I should be notified that :fields fields are too long
     */
    public function iShouldBeNotifiedThatFieldsAreTooLong(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                '%s can not be longer than',
                trim($field)
            ), false));
        }
    }

    /**
     * @Then I should be notified that there is already an existing section with provided code
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingSectionWithCode(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing section with this code.',
            false
        ));
    }

    /**
     * @Then I should be notified that new section has been created
     */
    public function iShouldBeNotifiedThatNewSectionHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Section has been successfully created.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the section has been deleted
     */
    public function iShouldBeNotifiedThatTheSectionHasBeenDeleted(): void
    {
        $this->notificationChecker->checkNotification(
            'Section has been successfully deleted.',
            NotificationType::success()
        );
    }

    /**
     * @Then the code field should be disabled
     */
    public function theCodeFieldShouldBeDisabled(): void
    {
        Assert::true($this->resolveCurrentPage()->isCodeDisabled());
    }

    /**
     * @Then I should see empty list of sections
     */
    public function iShouldSeeEmptyListOfSections(): void
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
