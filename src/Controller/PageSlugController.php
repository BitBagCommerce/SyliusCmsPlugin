<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller;

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
