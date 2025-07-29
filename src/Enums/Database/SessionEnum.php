<?php

namespace Narsil\Enums\Database;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum SessionEnum: string
{
    case ALL     = 'all';
    case CURRENT = 'current';
    case OTHERS  = 'others';
}
