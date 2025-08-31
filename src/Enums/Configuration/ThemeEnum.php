<?php

namespace Narsil\Enums\Configuration;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum ThemeEnum: string
{
    use Enumerable;

    case SYSTEM = 'system';
    case LIGHT = 'light';
    case DARK = 'dark';
}
