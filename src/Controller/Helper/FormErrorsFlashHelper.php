<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Controller\Helper;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;

final class FormErrorsFlashHelper implements FormErrorsFlashHelperInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private TranslatorInterface $translator,
    ) {
    }

    public function addFlashErrors(FormInterface $form): void
    {
        if ($form->isValid()) {
            return;
        }

        $errors = [];
        /** @var FormError $error */
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        $message = $this->translator->trans('sylius_cms_plugin.ui.form_was_submitted_with_errors') . ' ' . rtrim(implode(' ', $errors));

        $session = $this->requestStack->getSession()->getFlashBag();
        $session->set('error', $message);
    }
}
