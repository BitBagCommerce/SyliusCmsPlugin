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

final class PageSlugController
{
    /** @var SlugGeneratorInterface */
    private $slugGenerator;

    public function __construct(SlugGeneratorInterface $slugGenerator)
    {
        $this->slugGenerator = $slugGenerator;
    }

    public function generateAction(Request $request): JsonResponse
    {
        $name = $request->query->get('name');

        return new JsonResponse([
            'slug' => $this->slugGenerator->generate($name),
        ]);
    }
}
