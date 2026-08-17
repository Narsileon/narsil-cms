<?php

declare(strict_types=1);

namespace Narsil\Cms\Support\Facades;

#region USE

use Illuminate\Support\Facades\Facade;
use Narsil\Base\Contracts\Menus\AuthMenu as Contract;

#endregion

class AuthMenu extends Facade
{
    #region PROTECTED METHODS

    protected static function getFacadeAccessor(): string
    {
        return Contract::class;
    }

    #endregion
}
