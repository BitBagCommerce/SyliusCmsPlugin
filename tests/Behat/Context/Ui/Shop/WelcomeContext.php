<?php

namespace Tests\Acme\ExamplePlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\Acme\ExamplePlugin\Behat\Page\Shop\WelcomePageInterface;
use Webmozart\Assert\Assert;

final class WelcomeContext implements Context
{
    /**
     * @var WelcomePageInterface
     */
    private $staticWelcomePage;

    /**
     * @var WelcomePageInterface
     */
    private $dynamicWelcomePage;

    /**
     * @param WelcomePageInterface $staticWelcomePage
     * @param WelcomePageInterface $dynamicWelcomePage
     */
    public function __construct(WelcomePageInterface $staticWelcomePage, WelcomePageInterface $dynamicWelcomePage)
    {
        $this->staticWelcomePage = $staticWelcomePage;
        $this->dynamicWelcomePage = $dynamicWelcomePage;
    }

    /**
     * @When a customer with an unknown name visits static welcome page
     */
    public function customerWithUnknownNameVisitsStaticWelcomePage()
    {
        $this->staticWelcomePage->open();
    }

    /**
     * @When a customer named :name visits static welcome page
     */
    public function namedCustomerVisitsStaticWelcomePage($name)
    {
        $this->staticWelcomePage->open(['name' => $name]);
    }

    /**
     * @Then they should be statically greeted with :greeting
     */
    public function theyShouldBeStaticallyGreetedWithGreeting($greeting)
    {
        Assert::same($this->staticWelcomePage->getGreeting(), $greeting);
    }

    /**
     * @When a customer with an unknown name visits dynamic welcome page
     */
    public function customerWithUnknownNameVisitsDynamicWelcomePage()
    {
        $this->dynamicWelcomePage->open();
    }

    /**
     * @When a customer named :name visits dynamic welcome page
     */
    public function namedCustomerVisitsDynamicWelcomePage($name)
    {
        $this->dynamicWelcomePage->open(['name' => $name]);
    }

    /**
     * @Then they should be dynamically greeted with :greeting
     */
    public function theyShouldBeDynamicallyGreetedWithGreeting($greeting)
    {
        Assert::same($this->dynamicWelcomePage->getGreeting(), $greeting);
    }
}
