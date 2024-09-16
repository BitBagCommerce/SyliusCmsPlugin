<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Fixture\Factory;

use Sylius\CmsPlugin\Assigner\ChannelsAssignerInterface;
use Sylius\CmsPlugin\Assigner\CollectionsAssignerInterface;
use Sylius\CmsPlugin\Entity\ContentConfiguration;
use Sylius\CmsPlugin\Entity\MediaInterface;
use Sylius\CmsPlugin\Entity\PageInterface;
use Sylius\CmsPlugin\Entity\PageTranslationInterface;
use Sylius\CmsPlugin\Repository\MediaRepositoryInterface;
use Sylius\CmsPlugin\Repository\PageRepositoryInterface;
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

        foreach ($pageData['translations'] as $localeCode => $translation) {
            /** @var PageTranslationInterface $pageTranslation */
            $pageTranslation = $this->pageTranslationFactory->createNew();
            $slug = $translation['slug'] ?? md5(uniqid('', true));

            $pageTranslation->setLocale($localeCode);
            $pageTranslation->setSlug($slug);
            $pageTranslation->setTitle($translation['meta_title']);
            $pageTranslation->setMetaKeywords($translation['meta_keywords']);
            $pageTranslation->setMetaDescription($translation['meta_description']);
            $pageTranslation->setTeaserTitle($translation['teaser_title']);
            $pageTranslation->setTeaserContent($translation['teaser_content']);

            /** @var MediaInterface|null $mediaImage */
            $mediaImage = $this->mediaRepository->findOneBy(['code' => $translation['teaser_image']]);
            if ($mediaImage) {
                $pageTranslation->setTeaserImage($mediaImage);
            }

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
