<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Controller;

use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

final class PageSlugController
{
    public function __construct(private SlugGeneratorInterface $slugGenerator)
    {
    }

    public function generateAction(Request $request): JsonResponse
    {
        $name = $request->query->get('name');
        Assert::string($name);

        return new JsonResponse([
            'slug' => $this->slugGenerator->generate($name),
        ]);
    }
}
