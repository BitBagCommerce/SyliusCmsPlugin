<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller\Action\Admin;

use BitBag\SyliusCmsPlugin\Controller\Helper\FormErrorsFlashHelperInterface;
use BitBag\SyliusCmsPlugin\Exception\ImportFailedException;
use BitBag\SyliusCmsPlugin\Form\Type\ImportType;
use BitBag\SyliusCmsPlugin\Processor\ImportProcessorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

final class ImportDataAction
{
    public function __construct(
        private ImportProcessorInterface $importProcessor,
        private FormFactoryInterface $formFactory,
        private RequestStack $requestStack,
        private FormErrorsFlashHelperInterface $formErrorsFlashHelper,
        private TranslatorInterface $translator,
        private Environment $twig,
    ) {
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
                /** @var Session $session */
                $session = $this->requestStack->getSession();
                $flashBag = $session->getFlashBag();

                try {
                    $this->importProcessor->process($resourceName, $file->getPathname());

                    $flashBag->set('success', $this->translator->trans('bitbag_sylius_cms_plugin.ui.successfully_imported'));
                } catch (ImportFailedException $exception) {
                    $flashBag->set('error', $exception->getMessage());
                }
            } else {
                $this->formErrorsFlashHelper->addFlashErrors($form);
            }

            return new RedirectResponse($referer);
        }

        return new Response($this->twig->render('@BitBagSyliusCmsPlugin/Grid/Form/_importForm.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
