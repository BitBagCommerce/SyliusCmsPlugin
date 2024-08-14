<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace spec\BitBag\SyliusCmsPlugin\Renderer\ContentElement;

use BitBag\SyliusCmsPlugin\Entity\CollectionInterface;
use BitBag\SyliusCmsPlugin\Entity\ContentConfigurationInterface;
use BitBag\SyliusCmsPlugin\Form\Type\ContentElements\PagesCollectionContentElementType;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\ContentElementRendererInterface;
use BitBag\SyliusCmsPlugin\Renderer\ContentElement\PagesCollectionContentElementRenderer;
use BitBag\SyliusCmsPlugin\Repository\CollectionRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
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

        $twig->render('@BitBagSyliusCmsPlugin/Shop/ContentElement/index.html.twig', [
            'content_element' => '@BitBagSyliusCmsPlugin/Shop/ContentElement/_pages_collection.html.twig',
            'collection' => $pagesCollection,
        ])->willReturn('rendered_output');

        $this->render($contentConfiguration)->shouldReturn('rendered_output');
    }
}
