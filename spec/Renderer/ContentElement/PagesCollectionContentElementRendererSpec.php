<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Renderer\ContentElement;

use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Entity\CollectionInterface;
use Sylius\CmsPlugin\Entity\ContentConfigurationInterface;
use Sylius\CmsPlugin\Form\Type\ContentElements\PagesCollectionContentElementType;
use Sylius\CmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use Sylius\CmsPlugin\Renderer\ContentElement\PagesCollectionContentElementRenderer;
use Sylius\CmsPlugin\Repository\CollectionRepositoryInterface;
use Twig\Environment;

final class PagesCollectionContentElementRendererSpec extends ObjectBehavior
{
    public function let(Environment $twig, CollectionRepositoryInterface $collectionRepository): void
    {
        $this->beConstructedWith($twig, $collectionRepository);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PagesCollectionContentElementRenderer::class);
    }

    public function it_implements_content_element_renderer_interface(): void
    {
        $this->shouldImplement(ContentElementRendererInterface::class);
    }

    public function it_supports_pages_collection_content_element_type(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn(PagesCollectionContentElementType::TYPE);
        $this->supports($contentConfiguration)->shouldReturn(true);
    }

    public function it_does_not_support_other_content_element_types(ContentConfigurationInterface $contentConfiguration): void
    {
        $contentConfiguration->getType()->willReturn('other_type');
        $this->supports($contentConfiguration)->shouldReturn(false);
    }

    public function it_renders_pages_collection_content_element(
        Environment $twig,
        CollectionRepositoryInterface $collectionRepository,
        ContentConfigurationInterface $contentConfiguration,
        CollectionInterface $collection,
    ): void {
        $contentConfiguration->getConfiguration()->willReturn([
            'pages_collection' => 'collection_code',
        ]);

        $collectionRepository->findOneBy(['code' => 'collection_code'])->willReturn($collection);

        $pagesCollection = new ArrayCollection(['page1', 'page2']);
        $collection->getPages()->willReturn($pagesCollection);

        $twig->render('@SyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@SyliusCmsPlugin/Shop/ContentElement/_pages_collection.html.twig',
            'collection' => $pagesCollection,
        ])->willReturn('rendered_output');

        $this->render($contentConfiguration)->shouldReturn('rendered_output');
    }
}
