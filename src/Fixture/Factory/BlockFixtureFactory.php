<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Fixture\Factory;

use BitBag\SyliusCmsPlugin\Assigner\ChannelsAssignerInterface;
use BitBag\SyliusCmsPlugin\Assigner\CollectionsAssignerInterface;
use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class BlockFixtureFactory implements FixtureFactoryInterface
{
    public function __construct(
        private FactoryInterface $blockFactory,
        private BlockRepositoryInterface $blockRepository,
        private CollectionsAssignerInterface $collectionsAssigner,
        private ChannelsAssignerInterface $channelAssigner,
    ) {
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            /** @var ?BlockInterface $block */
            $block = $this->blockRepository->findOneBy(['code' => $code]);
            if (
                true === $fields['remove_existing'] &&
                null !== $block
            ) {
                $this->blockRepository->remove($block);
            }

            if (null !== $fields['number']) {
                for ($i = 0; $i < $fields['number']; ++$i) {
                    $this->createBlock(md5(uniqid()), $fields);
                }
            } else {
                $this->createBlock($code, $fields);
            }
        }
    }

    private function createBlock(string $code, array $blockData): void
    {
        /** @var BlockInterface $block */
        $block = $this->blockFactory->createNew();

        $this->collectionsAssigner->assign($block, $blockData['collections']);
        $this->channelAssigner->assign($block, $blockData['channels']);

        $block->setCode($code);
        $block->setEnabled($blockData['enabled']);

        $this->blockRepository->add($block);
    }
}
