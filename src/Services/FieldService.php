<?php

namespace Narsil\Services;

#region USE

use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FieldService
{
    #region PUBLIC METHODS

    /**
     * @param Field $field
     *
     * @return void
     */
    public static function replicateField(Field $field): void
    {
        $replicated = $field->replicate();

        $replicated
            ->fill([
                Field::HANDLE => DatabaseService::generateUniqueValue($replicated, Field::HANDLE, $field->{Field::HANDLE}),
            ])
            ->save();

        static::syncOptions($replicated, $field->options()->get()->toArray());
    }

    /**
     * @param Field $field
     * @param array $options
     *
     * @return void
     */
    public static function syncOptions(Field $field, array $options): void
    {
        $uuids = [];

        foreach ($options as $key => $option)
        {
            $fieldOption = FieldOption::updateOrCreate([
                FieldOption::FIELD_ID => $field->{Field::ID},
                FieldOption::VALUE => $option[FieldOption::VALUE],
            ], [
                FieldOption::POSITION => $key,
                FieldOption::LABEL => $option[FieldOption::LABEL],
            ]);

            $uuids[] = $fieldOption->{FieldOption::UUID};
        }

        $field->options()
            ->whereNotIn(FieldOption::UUID, $uuids)
            ->delete();
    }

    #endregion
}
