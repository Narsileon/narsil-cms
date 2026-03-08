<?php

namespace Narsil\Cms\Support\Facades;

#region USE

use Illuminate\Support\Facades\Facade;
use Narsil\Cms\Contracts\Menus\Sidebar as Contract;

#endregion

/**
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
