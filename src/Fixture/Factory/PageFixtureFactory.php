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
use BitBag\SyliusCmsPlugin\Entity\ContentConfiguration;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\PageTranslationInterface;
use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface;
use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class PageFixtureFactory implements FixtureFactoryInterface
{
    public function __construct(
        private FactoryInterface $pageFactory,
        private FactoryInterface $pageTranslationFactory,
        private PageRepositoryInterface $pageRepository,
        private MediaRepositoryInterface $mediaRepository,
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

            $this->createPage($code, $fields);
        }
    }

    private function createPage(
        string $code,
        array $pageData,
    ): void {
        /** @var PageInterface $page */
        $page = $this->pageFactory->createNew();

        $this->collectionsAssigner->assign($page, $pageData['collections']);
        $this->channelAssigner->assign($page, $pageData['channels']);

        $page->setCode($code);
        $page->setName($pageData['name']);
        $page->setEnabled($pageData['enabled']);

        /** @var MediaInterface|null $mediaImage */
        $mediaImage = $this->mediaRepository->findOneBy(['code' => $pageData['teaser_image']]);
        if ($mediaImage) {
            $page->setTeaserImage($mediaImage);
        }

        $page->setTeaserTitle($pageData['teaser_title']);
        $page->setTeaserContent($pageData['teaser_content']);

        foreach ($pageData['translations'] as $localeCode => $translation) {
            /** @var PageTranslationInterface $pageTranslation */
            $pageTranslation = $this->pageTranslationFactory->createNew();
            $slug = $translation['slug'] ?? md5(uniqid('', true));

            $pageTranslation->setLocale($localeCode);
            $pageTranslation->setSlug($slug);
            $pageTranslation->setTitle($translation['meta_title']);
            $pageTranslation->setMetaKeywords($translation['meta_keywords']);
            $pageTranslation->setMetaDescription($translation['meta_description']);

            $page->addTranslation($pageTranslation);
        }

        foreach ($pageData['content_elements'] as $data) {
            $data['data'] = array_filter($data['data'], static function ($value) {
                return !empty($value);
            });

            $contentConfiguration = new ContentConfiguration();
            $contentConfiguration->setType($data['type']);
            $contentConfiguration->setConfiguration($data['data']);
            $contentConfiguration->setPage($page);
            $page->addContentElement($contentConfiguration);
        }

        $this->pageRepository->add($page);
    }
}
