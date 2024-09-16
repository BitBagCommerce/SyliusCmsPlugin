<?php

declare(strict_types=1);

namespace spec\Sylius\CmsPlugin\Twig\Runtime;

use PhpSpec\ObjectBehavior;
use Sylius\CmsPlugin\Twig\Runtime\TranslationFormReduceRuntime;
use Symfony\Component\Form\FormView;

class TranslationFormReduceRuntimeSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TranslationFormReduceRuntime::class);
    }

    public function it_reduces_form_to_specified_fields(
        FormView $form,
        FormView $localeForm,
        FormView $slugForm,
        FormView $titleForm
    ): void {
        $form->children = [
            'en_US' => $localeForm
        ];

        $localeForm->children = [
            'slug' => $slugForm,
            'title' => $titleForm,
            'metaDescription' => new FormView(),
        ];

        $result = $this->reduceTranslationForm($form, ['slug', 'title']);
        $result->shouldHaveKey('en_US');
        $result['en_US']->shouldHaveKey('slug');
        $result['en_US']->shouldHaveKey('title');
        $result['en_US']->shouldNotHaveKey('metaDescription');
    }

    public function it_throws_exception_if_field_is_not_found(FormView $form, FormView $localeForm): void
    {
        $form->children = [
            'en_US' => $localeForm,
        ];

        $localeForm->children = [
            'metaDescription' => new FormView(),
        ];

        $this->shouldThrow(\InvalidArgumentException::class)->during('reduceTranslationForm', [$form, ['slug', 'title']]);
    }

    public function it_handles_multiple_locales(
        FormView $form,
        FormView $enLocale,
        FormView $deLocale,
        FormView $slugForm,
        FormView $titleForm
    ): void {
        $form->children = [
            'en_US' => $enLocale,
            'de_DE' => $deLocale,
        ];

        $enLocale->children = [
            'slug' => $slugForm,
            'title' => $titleForm,
        ];

        $deLocale->children = [
            'slug' => $slugForm,
            'title' => $titleForm,
        ];

        $result = $this->reduceTranslationForm($form, ['slug', 'title']);
        $result->shouldHaveCount(2);
        $result['en_US']->shouldHaveKey('slug');
        $result['en_US']->shouldHaveKey('title');
        $result['de_DE']->shouldHaveKey('slug');
        $result['de_DE']->shouldHaveKey('title');
    }

    public function it_throws_exception_if_field_is_not_present_in_multiple_locales(
        FormView $form,
        FormView $enLocale,
        FormView $deLocale,
        FormView $slugForm
    ): void {
        $form->children = [
            'en_US' => $enLocale,
            'de_DE' => $deLocale,
        ];

        $enLocale->children = [
            'slug' => $slugForm,
        ];

        $deLocale->children = [
            'slug' => $slugForm,
            // 'title' is missing in de_DE
        ];

        $this->shouldThrow(\InvalidArgumentException::class)->during('reduceTranslationForm', [$form, ['slug', 'title']]);
    }

    public function it_handles_empty_field_array(
        FormView $form,
        FormView $localeForm,
        FormView $slugForm,
        FormView $titleForm
    ): void {
        $form->children = [
            'en_US' => $localeForm,
        ];

        $localeForm->children = [
            'slug' => $slugForm,
            'title' => $titleForm,
        ];

        $result = $this->reduceTranslationForm($form, []);
        $result->shouldHaveCount(0);
    }
}
