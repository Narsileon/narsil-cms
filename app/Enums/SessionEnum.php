<?php

namespace App\Enums;

enum SessionEnum: string
{
    case ALL = 'all';
    case CURRENT = 'current';
    case OTHERS = 'others';
}
