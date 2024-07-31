<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Repository\TemplateRepositoryInterface;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Template\CreatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Template\IndexPageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Template\UpdatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;
use Webmozart\Assert\Assert;

final class TemplateContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private CurrentPageResolverInterface $currentPageResolver,
        private NotificationCheckerInterface $notificationChecker,
        private IndexPageInterface $indexPage,
        private CreatePageInterface $createPage,
        private UpdatePageInterface $updatePage,
        private TemplateRepositoryInterface $templateRepository,
        private RandomStringGeneratorInterface $randomStringGenerator,
    ) {
    }

    /**
     * @When I go to the create template page
     */
    public function iGoToTheCreateTemplatePage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I go to the templates page
     */
    public function iGoToTheTemplatesPage()
    {
        $this->indexPage->open();
    }

    /**
     * @When I fill the name with :name
     */
    public function iFillTheNameWith(string $name): void
    {
        $this->resolveCurrentPage()->fillName($name);
    }

    /**
     * @When I delete :name content element
     */
    public function iDeleteContentElement(string $name): void
    {
        $this->resolveCurrentPage()->deleteContentElement($name);
    }

    /**
     * @When I choose :type in Type field
     */
    public function iChooseInTypeField(string $type): void
    {
        $this->resolveCurrentPage()->chooseType($type);
    }

    /**
     * @Then I should be notified that the template has been created
     */
    public function iShouldBeNotifiedThatNewImageBlockHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Template has been successfully created.',
            NotificationType::success(),
        );
    }

    /**
     * @Then I should be notified that the template has been deleted
     */
    public function iShouldBeNotifiedThatTheTemplateHasBeenDeleted(): void
    {
        $this->notificationChecker->checkNotification(
            'Template has been successfully deleted.',
            NotificationType::success(),
        );
    }

    /**
     * @Then I should be notified that the template has been successfully updated
     */
    public function iShouldBeNotifiedThatTheTemplateHasBeenSuccessfullyUpdated(): void
    {
        $this->notificationChecker->checkNotification(
            'Template has been successfully updated.',
            NotificationType::success(),
        );
    }

    /**
     * @Then I should be notified that there is already existing template with provided name
     */
    public function iShouldBeNotifiedThatThereIsAlreadyExistingTemplateWithName(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing template with this name.',
            false,
        ));
    }

    /**
     * @Then I should be notified that :fields fields cannot be blank
     * @Then I should be notified that :fields field cannot be blank
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
     * @Then I should be notified that :fields field is too short
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
     * @Then I should be notified that :fields field is too long
     */
    public function iShouldBeNotifiedThatFieldsAreTooLong(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(sprintf(
                '%s can not be longer than %d characters.',
                trim($field),
                250,
            ), false));
        }
    }

    /**
     * @When /^I fill "([^"]*)" fields with (\d+) (?:character|characters)$/
     * @When /^I fill "([^"]*)" field with (\d+) (?:character|characters)$/
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
     * @When I click on Add button in Content elements section
     */
    public function iClickOnAddButtonInContentElementsSection(): void
    {
        $this->resolveCurrentPage()->clickOnAddContentElementButton();
    }

    /**
     * @When I select :option content element
     */
    public function iSelectContentElement(string $option): void
    {
        $this->resolveCurrentPage()->selectContentElement($option);
    }

    /**
     * @Then I should see only :name content element in Content elements section
     */
    public function iShouldSeeOnlyContentElementInContentElementsSection(string $name): void
    {
        Assert::true($this->resolveCurrentPage()->hasOnlyContentElement($name));
    }

    /**
     * @Then I should see newly created :contentElement content element in Content elements section
     */
    public function iShouldSeeNewlyCreatedContentElementInContentElementsSection(string $contentElement): void
    {
        Assert::true($this->resolveCurrentPage()->hasContentElement($contentElement));
    }

    /**
     * @When I delete this template
     */
    public function iDeleteThisTemplate()
    {
        $template = $this->sharedStorage->get('template');

        $this->indexPage->deleteTemplate($template);
    }

    /**
     * @Then I should see empty list of templates
     */
    public function iShouldSeeEmptyListOfTemplates(): void
    {
        $this->resolveCurrentPage()->isEmpty();
    }

    /**
     * @When I go to the update :name template page
     */
    public function iGoToTheUpdateTemplatePage(string $name)
    {
        $id = $this->templateRepository->findOneBy(['name' => $name])->getId();

        $this->updatePage->open(['id' => $id]);
    }

    /**
     * @When I update it
     */
    public function iUpdateIt(): void
    {
        $this->updatePage->saveChanges();
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
