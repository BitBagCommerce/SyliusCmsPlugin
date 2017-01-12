<?php

namespace Tests\Acme\ExampleBundle\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\Acme\ExampleBundle\Behat\Page\Shop\WelcomePageInterface;
use Webmozart\Assert\Assert;

final class WelcomeContext implements Context
{
    /**
     * @var WelcomePageInterface
     */
    private $welcomePage;

    /**
     * @param WelcomePageInterface $welcomePage
     */
    public function __construct(WelcomePageInterface $welcomePage)
    {
        $this->welcomePage = $welcomePage;
    }

    /**
     * @When a customer with an unknown name visits welcome page
     */
    public function customerWithUnknownNameVisitsWelcomePage()
    {
        $this->welcomePage->open();
    }

    /**
     * @When a customer named :name visits welcome page
     */
    public function namedCustomerVisitsWelcomePage($name)
    {
        $this->welcomePage->open(['name' => $name]);
    }

    /**
     * @Then they should be greeted with :greeting
     */
    public function theyShouldBeGreetedWithGreeting($greeting)
    {
        Assert::same($this->welcomePage->getGreeting(), $greeting);
    }
}
