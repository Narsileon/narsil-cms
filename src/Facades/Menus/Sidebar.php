<?php

namespace Narsil\Cms\Facades\Menus;

#region USE

use Illuminate\Support\Facades\Facade;
use Narsil\Cms\Contracts\Menus\Sidebar as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Sidebar extends Facade
{
    #region PROTECTED METHODS

    protected static function getFacadeAccessor(): string
    {
        return Contract::class;
    }

    #endregion
}
