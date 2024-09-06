<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Controller\Action\Admin;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProductSearchAction
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private LocaleContextInterface $localeContext,
        private ViewHandler $viewHandler,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $product = $this->productRepository->findByNamePart($request->get('phrase', ''), $this->localeContext->getLocaleCode());
        $view = View::create($product);

        $this->viewHandler->setExclusionStrategyGroups(['Autocomplete']);
        $view->getContext()->enableMaxDepth();

        return $this->viewHandler->handle($view);
    }
}
