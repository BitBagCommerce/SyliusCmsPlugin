<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\CmsPlugin\Controller;

use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class PageSlugController
{
    /**
     * @var SlugGeneratorInterface
     */
    private $slugGenerator;

    /**
     * @param SlugGeneratorInterface $slugGenerator
     */
    public function __construct(SlugGeneratorInterface $slugGenerator)
    {
        $this->slugGenerator = $slugGenerator;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function generateAction(Request $request): JsonResponse
    {
        $name = $request->query->get('name');

        return new JsonResponse([
            'slug' => $this->slugGenerator->generate($name),
        ]);
    }
}
