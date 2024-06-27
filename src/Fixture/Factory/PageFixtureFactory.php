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
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class PageFixtureFactory implements FixtureFactoryInterface
{
    public const CHANNEL_WITH_CODE_NOT_FOUND_MESSAGE = 'Channel with code "%s" not found';

    public function __construct(
        private FactoryInterface $pageFactory,
        private FactoryInterface $pageTranslationFactory,
        private PageRepositoryInterface $pageRepository,
        private CollectionsAssignerInterface $collectionsAssigner,
        private ChannelsAssignerInterface $channelAssigner,
    ) {
    }

    public function load(array $data): void
    {
        foreach ($data as $code => $fields) {
            /** @var ?PageInterface $page */
            $page = $this->pageRepository->findOneBy(['code' => $code]);
            if (
                true === $fields['remove_existing'] &&
                null !== $page
            ) {
                $this->pageRepository->remove($page);
            }

            if (null !== $fields['number']) {
                for ($i = 0; $i < $fields['number']; ++$i) {
                    $this->createPage(md5(uniqid()), $fields, true);
                }
            } else {
                $this->createPage($code, $fields);
            }
        }
    }

    private function createPage(
        string $code,
        array $pageData,
        bool $generateSlug = false,
    ): void {
        /** @var PageInterface $page */
        $page = $this->pageFactory->createNew();
        $channelsCodes = $pageData['channels'];
        $this->collectionsAssigner->assign($page, $pageData['collections']);
        $this->channelAssigner->assign($page, $channelsCodes);

        $page->setCode($code);
        $page->setEnabled($pageData['enabled']);

        foreach ($pageData['translations'] as $localeCode => $translation) {
            /** @var PageTranslationInterface $pageTranslation */
            $pageTranslation = $this->pageTranslationFactory->createNew();
            $slug = true === $generateSlug ? md5(uniqid()) : $translation['slug'];

            $pageTranslation->setLocale($localeCode);
            $pageTranslation->setSlug($slug);

            $page->addTranslation($pageTranslation);
            $page->setName($translation['name']);
            $page->setMetaKeywords($translation['meta_keywords']);
            $page->setMetaDescription($translation['meta_description']);
        }

        $this->pageRepository->add($page);
    }
}
