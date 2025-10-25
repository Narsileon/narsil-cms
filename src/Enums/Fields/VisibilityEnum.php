<?php

namespace Narsil\Enums\Fields;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum VisibilityEnum: string
{
    use Enumerable;

    case DISPLAY = 'display';
    case DISPLAY_WHEN = 'display_when';
    case HIDDEN = 'hidden';
    case HIDDEN_WHEN  = 'hidden_when';
}
