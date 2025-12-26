<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Input;
use Narsil\Models\Forms\FormPage;
use Narsil\Models\Forms\FormPageElement;
use Narsil\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FormService
{
    #region PUBLIC METHODS

    /**
     * @param Form $form
     *
     * @return void
     */
    public static function replicateForm(Form $form): void
    {
        $replicated = $form->replicate();

        $replicated
            ->fill([
                Form::HANDLE => DatabaseService::generateUniqueValue($replicated, Form::HANDLE, $form->{Form::HANDLE}),
            ])
            ->save();

        static::syncFormPages($replicated, $form->pages()->get()->toArray());
    }

    /**
     * @param FormPage $formPage
     * @param array $elements
     *
     * @return void
     */
    public static function syncFormPageElements(FormPage $formPage, array $elements): void
    {
        $formPage->fieldsets()->detach();
        $formPage->inputs()->detach();

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, FormPageElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $attributes = [
                FormPageElement::HANDLE => Arr::get($element, FormPageElement::HANDLE),
                FormPageElement::NAME => json_encode(Arr::get($element, FormPageElement::NAME, [])),
                FormPageElement::POSITION => $position,
                FormPageElement::WIDTH => Arr::get($element, FormPageElement::WIDTH, 100),
            ];

            match ($table)
            {
                Fieldset::TABLE => $formPage->fieldsets()->attach($id, $attributes),
                Input::TABLE => $formPage->inputs()->attach($id, $attributes),
                default => null,
            };
        }
    }

    /**
     * @param Form $form
     * @param array $pages
     *
     * @return void
     */
    public static function syncFormPages(Form $form, array $pages): void
    {
        $ids = [];

        foreach ($pages as $key => $page)
        {
            $formPage = FormPage::updateOrCreate([
                FormPage::FORM_ID => $form->{Form::ID},
                FormPage::HANDLE => Arr::get($page, FormPage::HANDLE),
            ], [
                FormPage::POSITION => $key,
                FormPage::NAME => Arr::get($page, FormPage::NAME),
            ]);

            static::syncFormPageElements($formPage, Arr::get($page, FormPage::RELATION_ELEMENTS, []));

            $ids[] = $formPage->{FormPage::ID};
        }

        $form
            ->pages()
            ->whereNotIn(FormPage::ID, $ids)
            ->delete();
    }

    #endregion
}
