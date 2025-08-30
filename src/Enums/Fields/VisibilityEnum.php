<?php

namespace Narsil\Enums\Fields;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum VisibilityEnum: string
{
    case DISPLAY = 'display';
    case DISPLAY_WHEN = 'display_when';
    case HIDDEN = 'hidden';
    case HIDDEN_WHEN  = 'hidden_when';
}
