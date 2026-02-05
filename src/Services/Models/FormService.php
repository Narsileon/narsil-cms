<?php

namespace Narsil\Cms\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Cms\Models\Forms\Form;
use Narsil\Cms\Models\Forms\FormStep;
use Narsil\Cms\Models\Forms\FormStepElement;
use Narsil\Cms\Models\Forms\FormWebhook;
use Narsil\Cms\Services\DatabaseService;

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
     * @param array $steps
     *
     * @return void
     */
    public static function syncFormSteps(Form $form, array $steps): void
    {
        $uuids = [];

        foreach ($steps as $key => $step)
        {
            $formStep = FormStep::updateOrCreate([
                FormStep::FORM_ID => $form->{Form::ID},
                FormStep::HANDLE => Arr::get($step, FormStep::HANDLE),
            ], [
                FormStep::POSITION => $key,
                FormStep::LABEL => Arr::get($step, FormStep::LABEL),
            ]);

            static::syncFormStepElements($formStep, Arr::get($step, FormStep::RELATION_ELEMENTS, []));

            $uuids[] = $formStep->{FormStep::UUID};
        }

        $form
            ->tabs()
            ->whereNotIn(FormStep::UUID, $uuids)
            ->delete();
    }

    /**
     * @param Form $form
     * @param array $webhooks
     *
     * @return void
     */
    public static function syncFormWebhooks(Form $form, array $webhooks): void
    {
        $uuids = [];

        foreach ($webhooks as $key => $webhook)
        {
            $formWebhook = FormWebhook::updateOrCreate([
                FormWebhook::FORM_ID => $form->{Form::ID},
                FormWebhook::URL => Arr::get($webhook, FormWebhook::URL),
            ], [
                FormWebhook::POSITION => $key,
            ]);

            $uuids[] = $formWebhook->{FormWebhook::UUID};
        }

        $form
            ->webhooks()
            ->whereNotIn(FormWebhook::UUID, $uuids)
            ->delete();
    }

    #endregion
}
