<?php

namespace Tests\Acme\ExamplePlugin\Behat\Page\Shop;

use Sylius\Behat\Page\SymfonyPage;

class StaticWelcomePage extends SymfonyPage implements WelcomePageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getGreeting(): string
    {
        return $this->getElement('greeting')->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'acme_example_static_welcome';
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
