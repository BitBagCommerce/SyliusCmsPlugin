<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Renderer\ContentElement;

use Twig\Environment;

abstract class AbstractContentElement implements ContentElementRendererInterface
{
    protected string $template;

    protected Environment $twig;

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function setTwigEnvironment(Environment $twig): void
    {
        $this->twig = $twig;
    }
}
