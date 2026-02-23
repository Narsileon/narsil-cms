<?php

namespace Narsil\Cms\Support\Facades;

#region USE

use Illuminate\Support\Facades\Facade;
use Narsil\Cms\Contracts\Menus\AuthMenu as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AuthMenu extends Facade
{
    #region PROTECTED METHODS

    protected static function getFacadeAccessor(): string
    {
        return Contract::class;
    }

    #endregion
}
