<?php

namespace App\Services;

#region USE

use App\Http\Forms\AbstractForm;
use Illuminate\Support\Facades\Config;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FormService
{
    #region PUBLIC METHODS

    /**
     * @param string $key
     *
     * @return class-string<AbstractForm>
     */
    public static function getForm(string $key): string
    {
        return Config::get("narsil.forms.$key");
    }

    #endregion
}
