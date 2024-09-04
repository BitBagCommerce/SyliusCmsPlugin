<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Form\DataTransformer;

use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class ContentElementDataTransformerChecker
{
    public function check(FormBuilderInterface $builder, RepositoryInterface $repository, string $field): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($repository, $field): void {
            $data = $event->getData();
            $code = $data[$field] ?? null;
            $entity = $repository->findOneBy(['code' => $code]);
            if (null === $entity) {
                $data[$field] = null;
                $event->setData($data);
            }
        });
    }
}
