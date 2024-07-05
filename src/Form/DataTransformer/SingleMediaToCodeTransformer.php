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
use Symfony\Component\Form\DataTransformerInterface;
use Webmozart\Assert\Assert;

final class SingleMediaToCodeTransformer implements DataTransformerInterface
{
    public function __construct(private MediaRepositoryInterface $mediaRepository)
    {
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function transform($value): ?MediaInterface
    {
        Assert::nullOrString($value);

        /** @var MediaInterface $media */
        $media = $this->mediaRepository->findOneBy(['code' => $value]);

        return $media;
    }

    /**
     * @throws \InvalidArgumentException
     * @param MediaInterface $value
     */
    public function reverseTransform($value): ?string
    {
        Assert::isInstanceOf($value, MediaInterface::class);

        return $value->getCode();
    }
}
