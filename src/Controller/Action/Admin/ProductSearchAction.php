<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller\Action\Admin;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProductSearchAction
{
    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ViewHandler */
    private $viewHandler;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        LocaleContextInterface $localeContext,
        ViewHandler $viewHandler
    ) {
        $this->productRepository = $productRepository;
        $this->localeContext = $localeContext;
        $this->viewHandler = $viewHandler;
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
