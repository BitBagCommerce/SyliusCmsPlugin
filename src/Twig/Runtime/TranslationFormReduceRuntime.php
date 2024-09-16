<?php

declare(strict_types=1);

namespace Sylius\CmsPlugin\Twig\Runtime;

use Symfony\Component\Form\FormView;

final class TranslationFormReduceRuntime implements TranslationFormReduceRuntimeInterface
{
    public function reduceTranslationForm(FormView $form, array $fields): array
    {
        $reducedForm = [];

        foreach ($form->children as $localeKey => $localeForm) {
            $localeReducedForm = [];

            foreach ($fields as $field) {
                if (!isset($localeForm->children[$field])) {
                    throw new \InvalidArgumentException(sprintf('Field "%s" does not exist in the form.', $field));
                }

                $localeReducedForm[$field] = $localeForm->children[$field];
            }

            if (!empty($localeReducedForm)) {
                $reducedForm[$localeKey] = $localeReducedForm;
            }
        }

        return $reducedForm;
    }
}
