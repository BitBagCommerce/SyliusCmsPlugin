<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusCmsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Behat\NotificationType;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block\CreatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block\IndexPageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Page\Admin\Block\UpdatePageInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\RandomStringGeneratorInterface;
use Tests\BitBag\SyliusCmsPlugin\Behat\Service\WysiwygHelper;
use Webmozart\Assert\Assert;

final class BlockContext implements Context
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

    /** @var BlockRepositoryInterface */
    private $blockRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        RandomStringGeneratorInterface $randomStringGenerator,
        BlockRepositoryInterface $blockRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->randomStringGenerator = $randomStringGenerator;
        $this->blockRepository = $blockRepository;
    }

    /**
     * @When I go to the blocks page
     */
    public function iGoToTheBlocksPage()
    {
        $this->indexPage->open();
    }

    /**
     * @When I go to the create block page
     */
    public function iGoToTheCreateImageBlockPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I delete this block
     */
    public function iDeleteThisBlock()
    {
        $block = $this->sharedStorage->get('block');

        $this->indexPage->deleteBlock($block->getCode());
    }

    /**
     * @When I go to the update :code block page
     */
    public function iGoToTheUpdateBlockPage(string $code)
    {
        $id = $this->blockRepository->findOneBy(['code' => $code])->getId();

        $this->updatePage->open(['id' => $id]);
    }

    /**
     * @When I want to edit this block
     */
    public function iWantToEditThisBlock()
    {
        $block = $this->sharedStorage->get('block');

        $this->updatePage->open(['id' => $block->getId()]);
    }

    /**
     * @When I fill :fields fields
     */
    public function iFillFields(string $fields): void
    {
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            $this->resolveCurrentPage()->fillField(trim($field), $this->randomStringGenerator->generate());
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
     * @When I fill the link with :link
     */
    public function iFillTheLinkWith(string $link): void
    {
        $this->resolveCurrentPage()->fillLink($link);
    }

    /**
     * @When I disable it
     */
    public function iDisableIt(): void
    {
        $this->resolveCurrentPage()->disable();
    }

    /**
     * @When I fill the content with :content
     */
    public function iFillTheContentWith(string $content): void
    {
        $this->resolveCurrentPage()->fillContent($content);
    }

    /**
     * @When I add :firstSection and :secondSection sections to it
     */
    public function iAddAndSectionsToIt(string ...$sectionsNames): void
    {
        $this->resolveCurrentPage()->associateSections($sectionsNames);
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
     * @When I update it
     */
    public function iUpdateIt(): void
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @Then I should be notified that the block has been created
     */
    public function iShouldBeNotifiedThatNewImageBlockHasBeenCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Block has been successfully created.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the block has been successfully updated
     */
    public function iShouldBeNotifiedThatTheBlockHasBeenSuccessfullyUpdated(): void
    {
        $this->notificationChecker->checkNotification(
            'Block has been successfully updated.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the block has been deleted
     */
    public function iShouldBeNotifiedThatTheBlockHasBeenDeleted(): void
    {
        $this->notificationChecker->checkNotification(
            'Block has been successfully deleted.',
            NotificationType::success()
        );
    }

    /**
     * @Then this block should be disabled
     */
    public function thisBlockShouldBeDisabled(): void
    {
        Assert::false($this->resolveCurrentPage()->isBlockDisabled());
    }

    /**
     * @Then I should be notified that :fields fields cannot be blank
     */
    public function iShouldBeNotifiedThatCannotBeBlank(string $fields): void
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
     * @Then I should be notified that there is already an existing block with provided code
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingBlockWithCode(): void
    {
        Assert::true($this->resolveCurrentPage()->containsErrorWithMessage(
            'There is an existing block with this code.',
            false
        ));
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
     * @Then the code field should be disabled
     */
    public function theCodeFieldShouldBeDisabled(): void
    {
        Assert::true($this->resolveCurrentPage()->isCodeDisabled());
    }

    /**
     * @Then I should see empty list of blocks
     */
    public function iShouldSeeEmptyListOfBlocks(): void
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
