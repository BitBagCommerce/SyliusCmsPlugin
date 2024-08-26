<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\Sylius\CmsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\Sylius\CmsPlugin\Behat\Page\Admin\Collection\CreatePageInterface;
use Tests\Sylius\CmsPlugin\Behat\Page\Admin\Collection\IndexPageInterface;
use Tests\Sylius\CmsPlugin\Behat\Page\Admin\Collection\UpdatePageInterface;
use Tests\Sylius\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;
use Webmozart\Assert\Assert;

final class CollectionContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private CurrentPageResolverInterface $currentPageResolver,
        private NotificationCheckerInterface $notificationChecker,
        private IndexPageInterface $indexPage,
        private CreatePageInterface $createPage,
        private UpdatePageInterface $updatePage,
        private RandomStringGeneratorInterface $randomStringGenerator,
    ) {
    }

    /**
     * @When I go to the collections page
     */
    public function iGoToTheCollectionsPage(): void
    {
        $this->indexPage->open();
    }

    /**
     * @When I go to the create collection page
     */
    public function iGoToTheCreateCollectionPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I delete this collection
     */
    public function iDeleteThisCollection(): void
    {
        $collection = $this->sharedStorage->get('collection');

        $this->indexPage->deleteCollection($collection->getCode());
    }

    /**
     * @When I want to edit this collection
     */
    public function iWantToEditThisCollection(): void
    {
        $collection = $this->sharedStorage->get('collection');

        $this->updatePage->open(['id' => $collection->getId()]);
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
            sleep(5);
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
     * @Then I should be notified that :fields fields are too long
     */
    public function iShouldBeNotifiedThatFieldsAreTooLong(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                '%s can not be longer than',
                trim($field),
            ), false));
        }
    }

    /**
     * @Then I should be notified that there is already an existing collection with provided code
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingCollectionWithCode(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing collection with this code.',
            false,
        ));
    }

    /**
     * @Then I should be notified that new collection has been created
     */
    public function iShouldBeNotifiedThatNewCollectionHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Collection has been successfully created.',
            NotificationType::success(),
        );
    }

    /**
     * @Then I should be notified that the collection has been deleted
     */
    public function iShouldBeNotifiedThatTheCollectionHasBeenDeleted(): void
    {
        $this->notificationChecker->checkNotification(
            'Collection has been successfully deleted.',
            NotificationType::success(),
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
     * @Then I should see empty list of collections
     */
    public function iShouldSeeEmptyListOfCollections(): void
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
