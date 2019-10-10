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
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class TaxonSearchAction
{
    /** @var TaxonRepositoryInterface */
    private $taxonRepository;

    /** @var LocaleContextInterface */
    private $localeContext;

    /** @var ViewHandler */
    private $viewHandler;

    public function __construct(
        TaxonRepositoryInterface $taxonRepository,
        LocaleContextInterface $localeContext,
        ViewHandler $viewHandler
    )
    {
        $this->taxonRepository = $taxonRepository;
        $this->localeContext = $localeContext;
        $this->viewHandler = $viewHandler;
    }

    public function __invoke(Request $request): Response
    {
        $taxon = $this->taxonRepository->findByNamePart($request->get('phrase', ''), $this->localeContext->getLocaleCode());
        $view = View::create($taxon);

        $this->viewHandler->setExclusionStrategyGroups(['Autocomplete']);
        $view->getContext()->enableMaxDepth();

        return $this->viewHandler->handle($view);
    }
}
