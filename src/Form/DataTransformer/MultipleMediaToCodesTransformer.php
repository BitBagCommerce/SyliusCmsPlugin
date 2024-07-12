<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\DataTransformer;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\DataTransformerInterface;
use Webmozart\Assert\Assert;

final class MultipleMediaToCodesTransformer implements DataTransformerInterface
{
    public function __construct(private MediaRepositoryInterface $mediaRepository)
    {
    }

    public function transform($value): Collection
    {
        Assert::nullOrIsArray($value);

        if (empty($value)) {
            return new ArrayCollection();
        }

        return new ArrayCollection($this->mediaRepository->findBy(['code' => $value]));
    }

    public function reverseTransform($value): array
    {
        Assert::isInstanceOf($value, Collection::class);

        $mediaCodes = [];

        /** @var MediaInterface $media */
        foreach ($value as $media) {
            $mediaCodes[] = $media->getCode();
        }

        return $mediaCodes;
    }
}
