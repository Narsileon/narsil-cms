<?php

declare(strict_types=1);

namespace Narsil\Cms\Support\Facades;

#region USE

use Illuminate\Support\Facades\Facade;
use Narsil\Cms\Contracts\Menus\CmsSidebar as Contract;

#endregion

final class CmsSidebar extends Facade
{
    #region PROTECTED METHODS

    protected static function getFacadeAccessor(): string
    {
        return Contract::class;
    }

    #endregion
}
