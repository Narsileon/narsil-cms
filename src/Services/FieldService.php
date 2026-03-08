<?php

namespace Narsil\Cms\Services;

#region USE

use Illuminate\Support\Str;

#endregion

/**
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

    #endregion
}
