<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Str;
use Narsil\Enums\ModelEventEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class ModelService
{
    #region PUBLIC METHODS

    /**
     * @param string $table
     * @param string $attribute
     * @param array $replace
     *
     * @return string
     */
    public static function getFieldDescription(string $table, string $attribute, array $replace = []): string
    {
        $key = "narsil::descriptions.$table.$attribute";

        $label = trans($key, $replace);

        if ($label === $key)
        {
            $label = "";
        }

        return $label;
    }

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
     * @param string $model
     * @param ModelEventEnum $event
     *
     * @return string
     */
    public static function getSuccessMessage(string $model, ModelEventEnum $event): string
    {
        $modelLabel = static::getModelLabel($model, false);
        $tableLabel = static::getTableLabel($model::TABLE, false);

        return trans("narsil::toasts.success.$event->value", [
            'model' => $modelLabel,
            'table' => $tableLabel,
        ]);
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
