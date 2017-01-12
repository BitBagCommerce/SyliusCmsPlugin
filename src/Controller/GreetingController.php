<?php

namespace Acme\ExampleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

final class GreetingController extends Controller
{
    public function greetAction()
    {
        return new Response('<html><body><div id="greeting">Hello!</div></body></html>');
    }
}
