<?php

namespace Narsil\Enums\Database;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum SessionEnum: string
{
    case ALL = 'all';
    case CURRENT = 'current';
    case OTHERS = 'others';
}
