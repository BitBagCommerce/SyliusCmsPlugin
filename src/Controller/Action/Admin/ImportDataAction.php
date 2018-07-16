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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Translation\TranslatorInterface;

final class ImportDataAction
{
    /** @var ImportProcessorInterface */
    private $importProcessor;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var FlashBagInterface */
    private $flashBag;

    /** @var TranslatorInterface */
    private $translator;

    /** @var ViewHandler */
    private $viewHandler;

    public function __construct(
        ImportProcessorInterface $importProcessor,
        FormFactoryInterface $formFactory,
        FlashBagInterface $flashBag,
        TranslatorInterface $translator,
        ViewHandler $viewHandler
    ) {
        $this->importProcessor = $importProcessor;
        $this->formFactory = $formFactory;
        $this->flashBag = $flashBag;
        $this->translator = $translator;
        $this->viewHandler = $viewHandler;
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->formFactory->create(ImportType::class);
        $referer = (string) $request->headers->get('referer');

        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isSubmitted()) {

            if ($form->isValid()) {
                /** @var UploadedFile $file */
                $file = $form->get('file')->getData();
                $resourceName = $request->get('resourceName');

                try {
                    $this->importProcessor->process($resourceName, $file->getPathname());

                    $this->flashBag->set('success', $this->translator->trans('bitbag_sylius_cms_plugin.ui.successfully_imported'));
                } catch (ImportFailedException $exception) {
                    $this->flashBag->set('error', $exception->getMessage());
                }
            } else {
                $this->flashBag->set('error', rtrim(implode($this->getFormErrors($form), ', '), ', '));
            }

            return new RedirectResponse($referer);
        }

        $view = View::create()
            ->setData([
                'form' => $form->createView(),
            ])
            ->setTemplate('@BitBagSyliusCmsPlugin/Grid/Form/_importForm.html.twig')
        ;

        return $this->viewHandler->handle($view);
    }

    private function getFormErrors(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return $errors;
    }
}
