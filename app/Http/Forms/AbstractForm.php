<?php

namespace App\Http\Forms;

#region USE

use App\Enums\Forms\MethodEnum;
use App\Structures\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractForm
{
    #region PUBLIC METHODS

    /**
     * @return array
     */
    public static function get(
        string $action,
        MethodEnum $method,
        string $submit,
        string $title,
    ): array
    {
        return [
            'action' => $action,
            'method' => $method->value,
            'submit' => $submit,
            'title' => $title,
            'inputs' => static::inputs(),
            'options' => static::options(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<Input>
     */
    abstract protected static function inputs(): array;

    /**
     * @return array<string>
     */
    protected static function options(): array
    {
        return [];
    }

    #endregion
}
