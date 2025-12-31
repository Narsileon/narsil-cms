<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FieldsetElement;
use Narsil\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FieldsetService
{
    #region PUBLIC METHODS

    /**
     * @param Fieldset $fieldset
     *
     * @return void
     */
    public static function replicate(Fieldset $fieldset): void
    {
        $replicated = $fieldset->replicate();

        $replicated
            ->fill([
                Fieldset::HANDLE => DatabaseService::generateUniqueValue($replicated, Fieldset::HANDLE, $fieldset->{Fieldset::HANDLE}),
            ])
            ->save();

        static::syncFieldsetElements($replicated, $fieldset->elements()->get()->toArray());
    }

    /**
     * @param Fieldset $fieldset
     * @param array $elements
     *
     * @return void
     */
    public static function syncFieldsetElements(Fieldset $fieldset, array $elements): void
    {
        $uuids = [];

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, FieldsetElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $fieldsetElement = FieldsetElement::updateOrCreate([
                FieldsetElement::OWNER_ID => $fieldset->{Fieldset::ID},
                FieldsetElement::HANDLE => Arr::get($element, FieldsetElement::HANDLE),
                FieldsetElement::ELEMENT_TYPE => $table,
                FieldsetElement::ELEMENT_ID => $id,
            ], [
                FieldsetElement::NAME => Arr::get($element, FieldsetElement::NAME, []),
                FieldsetElement::POSITION => $position,
                FieldsetElement::WIDTH => Arr::get($element, FieldsetElement::WIDTH, 100),
            ]);

            $uuids[] = $fieldsetElement->{FieldsetElement::UUID};
        }

        $fieldset
            ->elements()
            ->whereNotIn(FieldsetElement::UUID, $uuids)
            ->delete();
    }

    #endregion
}
