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
use Tests\Sylius\CmsPlugin\Behat\Page\Admin\Media\CreatePageInterface;
use Tests\Sylius\CmsPlugin\Behat\Page\Admin\Media\IndexPageInterface;
use Tests\Sylius\CmsPlugin\Behat\Page\Admin\Media\UpdatePageInterface;
use Tests\Sylius\CmsPlugin\Behat\Service\RandomStringGeneratorInterface;
use Webmozart\Assert\Assert;

final class MediaContext implements Context
{
    public function __construct(
        private CurrentPageResolverInterface $currentPageResolver,
        private NotificationCheckerInterface $notificationChecker,
        private IndexPageInterface $indexPage,
        private CreatePageInterface $createPage,
        private UpdatePageInterface $updatePage,
        private RandomStringGeneratorInterface $randomStringGenerator,
    ) {
    }

    /**
     * @When I go to the create media page
     */
    public function iGoToTheCreateMediaPage(): void
    {
        $this->createPage->open();
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
     * @When I fill the link content with :arg1
     */
    public function iFillTheContentWith(string $content): void
    {
        $this->resolveCurrentPage()->fillField('Link content', $content);
    }

    /**
     * @When I upload the :file image
     */
    public function iUploadTheImage(string $file): void
    {
        $this->resolveCurrentPage()->uploadFile($file);
    }

    /**
     * @When I add it
     * @When I try to add it
     */
    public function iAddIt(): void
    {
        $this->resolveCurrentPage()->create();
    }

    /**
     * @Then I should be notified that new media has been created
     */
    public function iShouldBeNotifiedThatNewMediaHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Media has been successfully created.',
            NotificationType::success(),
        );
    }

    /**
     * @Then I should be notified that there is already an existing media with provided code
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingMediaWithCode(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing media with this code.',
            false,
        ));
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
