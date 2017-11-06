<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\CmsPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use BitBag\CmsPlugin\Entity\BlockInterface;
use BitBag\CmsPlugin\Exception\TemplateTypeNotFound;
use BitBag\CmsPlugin\Repository\BlockRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Page\SymfonyPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block\CreatePageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block\IndexPageInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Block\UpdatePageInterface;
use Webmozart\Assert\Assert;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ManagingBlocksContext implements Context
{
    /**
     * @var IndexPageInterface
     */
    private $indexPage;

    /**
     * @var CreatePageInterface
     */
    private $createPage;

    /**
     * @var UpdatePageInterface
     */
    private $updatePage;

    /**
     * @var CurrentPageResolverInterface
     */
    private $currentPageResolver;

    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;

    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param IndexPageInterface $indexPage
     * @param CreatePageInterface $createPage
     * @param UpdatePageInterface $updatePage
     * @param CurrentPageResolverInterface $currentPageResolver
     * @param NotificationCheckerInterface $notificationChecker
     * @param SharedStorageInterface $sharedStorage
     * @param BlockRepositoryInterface $blockRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage,
        CurrentPageResolverInterface $currentPageResolver,
        NotificationCheckerInterface $notificationChecker,
        SharedStorageInterface $sharedStorage,
        BlockRepositoryInterface $blockRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->indexPage = $indexPage;
        $this->currentPageResolver = $currentPageResolver;
        $this->notificationChecker = $notificationChecker;
        $this->sharedStorage = $sharedStorage;
        $this->blockRepository = $blockRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @When I go to the cms blocks page
     */
    public function iGoToTheCmsBlocksPage()
    {
        $this->indexPage->open();
    }

    /**
     * @When I go to the create :blockType block page
     */
    public function iGoToTheCreateImageBlockPage(string $blockType): void
    {

        if (BlockInterface::TEXT_BLOCK_TYPE === $blockType) {
            $this->createPage->open(['type' => BlockInterface::TEXT_BLOCK_TYPE]);

            return;
        }

        if (BlockInterface::HTML_BLOCK_TYPE === $blockType) {
            $this->createPage->open(['type' => BlockInterface::HTML_BLOCK_TYPE]);

            return;
        }

        if (BlockInterface::IMAGE_BLOCK_TYPE === $blockType) {
            $this->createPage->open(['type' => BlockInterface::IMAGE_BLOCK_TYPE]);

            return;
        }

        throw new TemplateTypeNotFound($blockType);
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
     * @When I upload the :image image
     */
    public function iUploadTheImage(string $image): void
    {
        $this->resolveCurrentPage()->uploadImage($image);
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
     * @When I remove this image block
     */
    public function iRemoveThisImageBlock(): void
    {
        /** @var BlockInterface $block */
        $block = $this->sharedStorage->get('block');
        $code = $block->getCode();

        $this->indexPage->removeBlock($code);
    }

    /**
     * @When I add it
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
     * @Then no dynamic content blocks should appear in the store
     */
    public function noDynamicContentBlocksShouldAppearInTheStore(): void
    {
        Assert::eq(0, count($this->blockRepository->findAll()));
    }

    /**
     * @Then I should see :number dynamic content blocks with :type type
     */
    public function iShouldSeeDynamicContentBlocksWithType(int $number, string $type): void
    {
        Assert::eq($number, $this->indexPage->getBlocksWithTypeCount($type));
    }

    /**
     * @Then I should be notified that new image block was created
     * @Then I should be notified that new text block was created
     */
    public function iShouldBeNotifiedThatNewImageBlockWasCreated(): void
    {
        $this->notificationChecker->checkNotification(
            "Block has been successfully created.",
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that the block was successfully updated
     */
    public function iShouldBeNotifiedThatTheBlockWasSuccessfullyUpdated(): void
    {
        $this->notificationChecker->checkNotification(
            "Block has been successfully updated.",
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that this block was removed
     */
    public function iShouldBeNotifiedThatThisBlockWasRemoved(): void
    {
        $this->notificationChecker->checkNotification(
            "Block has been successfully deleted.",
            NotificationType::success()
        );
    }

    /**
     * @Then block with :code code and :content content should exist in the store
     */
    public function blockWithCodeAndContentShouldBeInTheStore(string $code, string $content): void
    {
        $block = $this->blockRepository->findEnabledByCodeAndContent($code, $content);

        Assert::isInstanceOf($block, BlockInterface::class);
    }

    /**
     * @Then block with :type type and :content content should exist in the store
     */
    public function blockWithTypeAndContentShouldBeInTheStore(string $type, string $content): void
    {
        $block = $this->blockRepository->findOneByTypeAndContent($type, $content);

        $this->sharedStorage->set('block', $block);

        Assert::isInstanceOf($block, BlockInterface::class);
    }

    /**
     * @Then this block should also have :name name and :link link
     * @Then this block should also have :name name
     */
    public function thisBlockShouldAlsoHaveNameAndLink(string $name, string $link = null): void
    {
        /** @var BlockInterface $block */
        $block = $this->sharedStorage->get('block');

        Assert::eq($name, $block->getName());
        Assert::eq($link, $block->getLink());
    }

    /**
     * @Then image block with :code code and :image image should exist in the store
     */
    public function imageBlockWithTypeAndImageShouldBeInTheStore(string $code, string $image): void
    {
        $block = $this->blockRepository->findOneBy(['code' => $code]);
        $blockImage = $block->getImage();
        $this->entityManager->refresh($blockImage);
        $this->sharedStorage->set('block', $block);

        Assert::eq(BlockInterface::IMAGE_BLOCK_TYPE, $block->getType());
        Assert::eq(
            file_get_contents(__DIR__ . '/../../../../Application/web/media/image/' . $block->getImage()->getPath()),
            file_get_contents(__DIR__ . '/../../../Resources/images/' . $image)
        );
    }

    /**
     * @Then I should be able to select between :firstBlockType, :secondBlockType and :thirdBlockType block types under Create button
     */
    public function iShouldBeAbleToSelectBetweenAndBlockTypesUnderCreateButton(string ...$blockTypes): void
    {
        $blockTypesOnPage = $this->indexPage->getBlockTypes();

        Assert::eq(count($blockTypesOnPage), count($blockTypes));

        foreach ($blockTypes as $blockType) {
            Assert::oneOf($blockType, $blockTypesOnPage);
        }
    }

    /**
     * @Then block with :code should not appear in the store
     */
    public function blockWithShouldNotAppearInTheStore(string $code): void
    {
        Assert::null($this->blockRepository->findEnabledByCode($code));
    }

    /**
     * @return CreatePageInterface|UpdatePageInterface|SymfonyPageInterface
     */
    private function resolveCurrentPage(): SymfonyPageInterface
    {
        return $this->currentPageResolver->getCurrentPageWithForm([$this->createPage, $this->updatePage]);
    }
}
