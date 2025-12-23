<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class ModelService
{
    #region PUBLIC METHODS

    /**
     * @param string $model
     * @param boolean $ucFirst
     * @param string|null $locale
     * 
     * @return string
     */
    public static function getModelLabel(string $model, bool $ucFirst = true, ?string $locale = null): string
    {
        $key = "narsil::models.$model";

        $label = trans($key, [], $locale);

        if ($label === $key)
        {
            $label = $model;
        }

        if ($ucFirst)
        {
            $label = Str::ucfirst($label);
        }

        return $label;
    }

    /**
     * @param string $table
     * @param boolean $ucFirst
     * @param string|null $locale
     * 
     * @return string
     */
    public static function getTableLabel(string $table, bool $ucFirst = true, ?string $locale = null): string
    {
        $key = "narsil::tables.$table";

        $label = trans($key, [], $locale);

        if ($label === $key)
        {
            $label = $table;
        }

        if ($ucFirst)
        {
            $label = Str::ucfirst($label);
        }

        return $label;
    }
}
