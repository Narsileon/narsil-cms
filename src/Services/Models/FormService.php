<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormStep;
use Narsil\Models\Forms\FormStepElement;
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

        static::syncFormSteps($replicated, $form->pages()->get()->toArray());
    }

    /**
     * @param FormStep $formStep
     * @param array $elements
     *
     * @return void
     */
    public static function syncFormStepElements(FormStep $formStep, array $elements): void
    {
        $uuids = [];

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, FormStepElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $formStepElement = FormStepElement::updateOrCreate([
                FormStepElement::OWNER_UUID => $formStep->{FormStep::UUID},
                FormStepElement::HANDLE => Arr::get($element, FormStepElement::HANDLE),
                FormStepElement::BASE_TYPE => $table,
                FormStepElement::BASE_ID => $id,
            ], [
                FormStepElement::DESCRIPTION => Arr::get($element, FormStepElement::DESCRIPTION),
                FormStepElement::LABEL => Arr::get($element, FormStepElement::LABEL),
                FormStepElement::POSITION => $position,
                FormStepElement::REQUIRED => Arr::get($element, FormStepElement::REQUIRED, false),
                FormStepElement::WIDTH => Arr::get($element, FormStepElement::WIDTH, 100),
            ]);

            ElementService::syncConditions($formStepElement, Arr::get($element, FormStepElement::RELATION_CONDITIONS, []));

            $uuids[] = $formStepElement->{FormStepElement::UUID};
        }

        $formStep
            ->elements()
            ->whereNotIn(FormStepElement::UUID, $uuids)
            ->delete();
    }

    /**
     * @param Form $form
     * @param array $pages
     *
     * @return void
     */
    public static function syncFormSteps(Form $form, array $pages): void
    {
        $uuids = [];

        foreach ($pages as $key => $page)
        {
            $formStep = FormStep::updateOrCreate([
                FormStep::FORM_ID => $form->{Form::ID},
                FormStep::HANDLE => Arr::get($page, FormStep::HANDLE),
            ], [
                FormStep::POSITION => $key,
                FormStep::LABEL => Arr::get($page, FormStep::LABEL),
            ]);

            static::syncFormStepElements($formStep, Arr::get($page, FormStep::RELATION_ELEMENTS, []));

            $uuids[] = $formStep->{FormStep::UUID};
        }

        $form
            ->tabs()
            ->whereNotIn(FormStep::UUID, $uuids)
            ->delete();
    }

    #endregion
}
