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
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\Behat\Service\Resolver\CurrentPageResolverInterface;
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\Section\CreatePageInterface;

/**
 * @author Patryk Drapik <patryk.drapik@bitbag.pl>
 */
final class SectionContext implements Context
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
     * @When I go to the create new section page
     */
    public function iGoToTheCreateNewSectionPage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I fill the code with :code
     */
    public function iFillTheCodeWith(string $code): void
    {
        $this->createPage->fillCode($code);
    }

    /**
     * @When I fill the name with :name
     */
    public function iFillTheNameWith(string $name): void
    {
        $this->createPage->fillName($name);
    }

    /**
     * @When I add it
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @Then I should be notified that new section has been created
     */
    public function iShouldBeNotifiedThatNewSectionHasBeenCreated()
    {
        $this->notificationChecker->checkNotification(
            'Success Section has been successfully created.',
            NotificationType::success()
        );
    }
}
