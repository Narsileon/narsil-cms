<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Str;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\FieldOption;
use Narsil\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FieldService
{
    #region PUBLIC METHODS

    /**
     * Get the icon of the field.
     *
     * @return string
     */
    public static function getIcon(string $type): string
    {
        $baseName = class_basename($type);

        $fieldName  = Str::beforeLast($baseName, 'Field');

        return Str::kebab($fieldName);
    }

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

        static::syncFieldOptions($replicated, $field->options()->get()->toArray());
    }

    /**
     * @param Field $field
     * @param array $options
     *
     * @return void
     */
    public static function syncFieldOptions(Field $field, array $options): void
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

        $field
            ->options()
            ->whereNotIn(FieldOption::UUID, $uuids)
            ->delete();
    }

    #endregion
}
