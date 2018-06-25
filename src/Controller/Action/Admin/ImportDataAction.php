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

use BitBag\SyliusCmsPlugin\Exception\ImportFailedException;
use BitBag\SyliusCmsPlugin\Form\Type\ImportType;
use BitBag\SyliusCmsPlugin\Processor\ImportProcessorInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

final class ImportDataAction
{
    /** @var ImportProcessorInterface */
    private $importProcessor;

    /** @var Session */
    private $session;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var ViewHandler */
    private $viewHandler;

    public function __construct(
        ImportProcessorInterface $importProcessor,
        Session $session,
        FormFactoryInterface $formFactory,
        ViewHandler $viewHandler
    ) {
        $this->importProcessor = $importProcessor;
        $this->session = $session;
        $this->formFactory = $formFactory;
        $this->viewHandler = $viewHandler;
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(ImportType::class);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                /** @var UploadedFile $file */
                $file = $form->getData()['file'];

                $resourceName = $request->get('resourceName');

                $flashBag = $this->session->getFlashBag();

                try {
                    $this->importProcessor->process($resourceName, $file->getPathname());

                    $flashBag->set('success', 'bitbag_sylius_cms_plugin.ui.successfully_imported');
                } catch (ImportFailedException $exception) {
                    $flashBag->set('error', $exception->getMessage());
                }

                $referer = (string) $request->headers->get('referer');

                return new RedirectResponse($referer);
            }
        }

        $view = View::create()
            ->setData([
                'form' => $form->createView(),
            ])
            ->setTemplate('@BitBagSyliusCmsPlugin/Import/_form.html.twig')
        ;

        return $this->viewHandler->handle($view, $request);
    }
}
