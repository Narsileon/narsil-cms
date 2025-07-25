<?php

namespace Narsil\Enums\Fields;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum VisibilityModeEnum: string
{
    case HIDDEN      = 'hidden';
    case HIDDEN_WHEN = 'hidden_when';
    case SHOW        = 'show';
    case SHOW_WHEN   = 'show_when';
}
