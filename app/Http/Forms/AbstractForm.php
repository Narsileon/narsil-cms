<?php

namespace App\Http\Forms;

#region USE

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
    public static function get(): array
    {
        return [
            'inputs' => static::inputs()
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<Input>
     */
    abstract protected static function inputs(): array;

    #endregion
}
