<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Doctrine\ORM\Extension;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Sylius\Bundle\ApiBundle\Context\UserContextInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;

final class EnabledAndAvailableExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function __construct(
        private UserContextInterface $userContext,
        private ChannelContextInterface $channelContext,
    ) {
    }

    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = [],
    ): void {
        $this->addEnabledAndChannelCondition($queryBuilder, $queryNameGenerator, $resourceClass);
    }

    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        Operation $operation = null,
        array $context = [],
    ): void {
        $this->addEnabledAndChannelCondition($queryBuilder, $queryNameGenerator, $resourceClass);
    }

    private function addEnabledAndChannelCondition(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass): void
    {
        $rootAlias = $queryBuilder->getRootAliases()[0];

        $user = $this->userContext->getUser();
        if (null !== $user && in_array('ROLE_API_ACCESS', $user->getRoles(), true)) {
            return;
        }

        if (in_array(ToggleableInterface::class, (array) class_implements($resourceClass), true)){
            $queryBuilder
                ->andWhere(sprintf('%s.enabled = :enabled', $rootAlias))
                ->setParameter('enabled', true);
        }

        if (in_array(ChannelsAwareInterface::class, (array) class_implements($resourceClass), true)) {
            $channelAlias = $queryNameGenerator->generateJoinAlias('channel');
            $queryBuilder
                ->innerJoin(sprintf('%s.channels', $rootAlias), $channelAlias)
                ->andWhere(sprintf('%s.code = :channel', $channelAlias))
                ->setParameter('channel', $this->channelContext->getChannel()->getCode());
        }
    }
}
