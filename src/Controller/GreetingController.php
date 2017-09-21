<?php

namespace Acme\ExamplePlugin\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

final class GreetingController extends Controller
{
    /**
     * @param string|null $name
     *
     * @return Response
     */
    public function staticallyGreetAction(?string $name): Response
    {
        return $this->render('@AcmeExamplePlugin/static_greeting.html.twig', ['greeting' => $this->getGreeting($name)]);
    }

    /**
     * @param string|null $name
     *
     * @return Response
     */
    public function dynamicallyGreetAction(?string $name): Response
    {
        return $this->render('@AcmeExamplePlugin/dynamic_greeting.html.twig', ['greeting' => $this->getGreeting($name)]);
    }

    /**
     * @param string|null $name
     *
     * @return string
     */
    private function getGreeting(?string $name): string
    {
        switch ($name) {
            case null:
                return 'Hello!';

            case 'Lionel Richie':
                return 'Hello, is it me you\'re looking for?';

            default:
                return sprintf('Hello, %s!', $name);
        }
    }
}
