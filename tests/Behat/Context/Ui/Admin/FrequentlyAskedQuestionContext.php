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
use Tests\BitBag\CmsPlugin\Behat\Page\Admin\FrequentlyAskedQuestion\CreatePageInterface;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class FrequentlyAskedQuestionContext implements Context
{
    /**
     * @var CreatePageInterface
     */
    private $createPage;

    /**
     * @param CreatePageInterface $createPage
     */
    public function __construct(CreatePageInterface $createPage)
    {
        $this->createPage = $createPage;
    }

    /**
     * @When I go to the create faq page
     */
    public function iGoToTheCreateFaqPage()
    {
        $this->createPage->open();
    }

    /**
     * @When I fill code with :code
     */
    public function iFillCodeWith($code)
    {
        $this->createPage->fillCode($code);
    }

    /**
     * @When I set the position to :position
     */
    public function iSetThePositionTo($position)
    {

    }

    /**
     * @When I fill the question with :question
     */
    public function iFillTheQuestionWith($question)
    {
    }

    /**
     * @When I set the answer to :answer
     */
    public function iSetTheAnswerTo($answer)
    {
    }

    /**
     * @When I add it
     */
    public function iAddIt()
    {

    }

    /**
     * @Then I should be notified that a new faq has been created
     */
    public function iShouldBeNotifiedThatANewFaqHasBeenCreated()
    {

    }

    /**
     * @Then I should be notified that :fields can not be blank
     */
    public function iShouldBeNotifiedThatCanNotBeBlank($fields)
    {

    }


    /**
     * @Then I should be notified that there is already an existing faq with selected position
     */
    public function iShouldBeNotifiedThatThereIsAlreadyAnExistingFaqWithSelectedPosition()
    {

    }

    /**
     * @Then I should be suggested to select :arg1 position
     */
    public function iShouldBeSuggestedToSelectPosition($arg1)
    {

    }
}