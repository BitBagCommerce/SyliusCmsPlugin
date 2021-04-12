<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Controller\Helper;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class FormErrorsFlashHelper implements FormErrorsFlashHelperInterface
{
    /** @var FlashBagInterface */
    private $flashBag;

    /** @var TranslatorInterface */
    private $translator;

    public function __construct(FlashBagInterface $flashBag, TranslatorInterface $translator)
    {
        $this->flashBag = $flashBag;
        $this->translator = $translator;
    }

    public function addFlashErrors(FormInterface $form): void
    {
        if ($form->isValid()) {
            return;
        }

        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        $message = $this->translator->trans('bitbag_sylius_cms_plugin.ui.form_was_submitted_with_errors') . ' ' . rtrim(implode($errors, " "));

        $this->flashBag->set('error', $message);
    }
}
