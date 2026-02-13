<?php

namespace Narsil\Cms\Services;

#region USE

use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Helpers\Translator;
use Narsil\Base\Services\ModelService as BaseModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class ModelService extends BaseModelService
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
        return Translator::trans("fields.descriptions.$table.$attribute", $replace);
    }

    /**
     * @param string $model
     * @param ModelEventEnum $event
     *
     * @return string
     */
    public static function getSuccessMessage(string $table, ModelEventEnum $event): string
    {
        $modelLabel = static::getModelLabel($table, false);
        $tableLabel = static::getTableLabel($table, false);

        return Translator::trans("toasts.success.$event->value", [
            'model' => $modelLabel,
            'table' => $tableLabel,
        ]);
    }
}
