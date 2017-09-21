<?php

namespace Tests\Acme\ExamplePlugin\Behat\Page\Shop;

use Sylius\Behat\Page\SymfonyPage;

class DynamicWelcomePage extends SymfonyPage implements WelcomePageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getGreeting(): string
    {
        return $this->getSession()->getPage()->waitFor(3, function (): string {
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
    public function getRouteName(): string
    {
        return 'acme_example_dynamic_welcome';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'greeting' => '#greeting',
        ]);
    }
}
