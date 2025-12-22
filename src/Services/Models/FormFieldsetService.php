<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\Forms\FormFieldsetElement;
use Narsil\Models\Forms\FormInput;
use Narsil\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FormFieldsetService
{
    #region PUBLIC METHODS

    /**
     * @param FormFieldset $formFieldset
     *
     * @return void
     */
    public static function replicateFormFieldset(FormFieldset $formFieldset): void
    {
        $replicated = $formFieldset->replicate();

        $replicated
            ->fill([
                FormFieldset::HANDLE => DatabaseService::generateUniqueValue($replicated, FormFieldset::HANDLE, $formFieldset->{FormFieldset::HANDLE}),
            ])
            ->save();

        static::syncFieldsetElements($replicated, $formFieldset->elements()->get()->toArray());
    }

    /**
     * @param FormFieldset $formFieldset
     * @param array $elements
     *
     * @return void
     */
    public static function syncFieldsetElements(FormFieldset $formFieldset, array $elements): void
    {
        $formFieldset->inputs()->detach();

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, FormFieldsetElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || !Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $attributes = [
                FormFieldsetElement::HANDLE => Arr::get($element, FormFieldsetElement::HANDLE),
                FormFieldsetElement::NAME => json_encode(Arr::get($element, FormFieldsetElement::NAME)),
                FormFieldsetElement::POSITION => $position,
                FormFieldsetElement::WIDTH => Arr::get($element, FormFieldsetElement::WIDTH, 100),
            ];

            match ($table)
            {
                FormInput::TABLE => $formFieldset->inputs()->attach($id, $attributes),
                default => null,
            };
        }
    }

    #endregion
}
