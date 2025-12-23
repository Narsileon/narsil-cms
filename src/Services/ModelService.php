<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Str;
use Narsil\Enums\Database\EventEnum;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;

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
     * @param string $model
     * @param EventEnum $event
     * 
     * @return string
     */
    public static function getSuccessMessage(string $model, EventEnum $event): string
    {
        $isEntity = $model === Entity::class;

        $modelLabel = $isEntity ? Entity::getTemplate()?->{Template::SINGULAR} : static::getModelLabel($model, false);
        $tableLabel = $isEntity ? Entity::getTemplate()?->{Template::PLURAL} : static::getTableLabel($model::TABLE, false);

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
