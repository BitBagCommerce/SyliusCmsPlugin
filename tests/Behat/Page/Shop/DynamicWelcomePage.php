<?php

namespace Tests\Acme\ExampleBundle\Behat\Page\Shop;

use Sylius\Behat\Page\SymfonyPage;

class DynamicWelcomePage extends SymfonyPage implements WelcomePageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getGreeting()
    {
        return $this->getSession()->getPage()->waitFor(3, function () {
            $greeting = $this->getElement('greeting')->getText();

            if ('Loading...' === $greeting) {
                return false;
            }

            return $greeting;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteName()
    {
        return 'acme_example_dynamic_welcome';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'greeting' => '#greeting',
        ]);
    }
}
