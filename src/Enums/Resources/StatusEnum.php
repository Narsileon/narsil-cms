<?php

namespace Narsil\Enums\Resources;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum StatusEnum: string
{
    case DRAFT     = 'draft';
    case EXPIRED   = 'expired';
    case LIVE      = 'live';
    case SCHEDULED = 'scheduled';
}
