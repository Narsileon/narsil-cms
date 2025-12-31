<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Input;
use Narsil\Models\Forms\FormTab;
use Narsil\Models\Forms\FormTabElement;
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
    public static function replicate(Form $form): void
    {
        $replicated = $form->replicate();

        $replicated
            ->fill([
                Form::SLUG => DatabaseService::generateUniqueValue($replicated, Form::SLUG, $form->{Form::SLUG}),
            ])
            ->save();

        static::syncFormTabs($replicated, $form->pages()->get()->toArray());
    }

    /**
     * @param FormTab $formTab
     * @param array $elements
     *
     * @return void
     */
    public static function syncFormTabElements(FormTab $formTab, array $elements): void
    {
        $formTab->fieldsets()->detach();
        $formTab->inputs()->detach();

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, FormTabElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $attributes = [
                FormTabElement::HANDLE => Arr::get($element, FormTabElement::HANDLE),
                FormTabElement::NAME => Arr::get($element, FormTabElement::NAME, []),
                FormTabElement::POSITION => $position,
                FormTabElement::WIDTH => Arr::get($element, FormTabElement::WIDTH, 100),
            ];

            match ($table)
            {
                Fieldset::TABLE => $formTab->fieldsets()->attach($id, $attributes),
                Input::TABLE => $formTab->inputs()->attach($id, $attributes),
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
    public static function syncFormTabs(Form $form, array $pages): void
    {
        $uuids = [];

        foreach ($pages as $key => $page)
        {
            $formTab = FormTab::updateOrCreate([
                FormTab::FORM_ID => $form->{Form::ID},
                FormTab::HANDLE => Arr::get($page, FormTab::HANDLE),
            ], [
                FormTab::POSITION => $key,
                FormTab::NAME => Arr::get($page, FormTab::NAME),
            ]);

            static::syncFormTabElements($formTab, Arr::get($page, FormTab::RELATION_ELEMENTS, []));

            $uuids[] = $formTab->{FormTab::UUID};
        }

        $form
            ->pages()
            ->whereNotIn(FormTab::UUID, $uuids)
            ->delete();
    }

    #endregion
}
