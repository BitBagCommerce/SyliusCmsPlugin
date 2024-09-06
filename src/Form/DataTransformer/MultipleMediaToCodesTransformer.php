<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
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
