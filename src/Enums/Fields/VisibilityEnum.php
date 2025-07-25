<?php

namespace Narsil\Enums\Fields;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum VisibilityEnum: string
{
    case DISPLAY      = 'display';
    case DISPLAY_WHEN = 'display_when';
    case HIDDEN       = 'hidden';
    case HIDDEN_WHEN  = 'hidden_when';
}
