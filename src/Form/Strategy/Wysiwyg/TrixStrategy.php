<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusCmsPlugin\Form\Strategy\Wysiwyg;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

final class TrixStrategy extends AbstractWysiwygStrategy
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['block_prefix'] = 'bitbag_sylius_cms_plugin_trix_strategy';
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_cms_plugin_trix_strategy';
    }
}
