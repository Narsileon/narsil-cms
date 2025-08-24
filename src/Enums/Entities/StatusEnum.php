<?php

namespace Narsil\Enums\Entities;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum StatusEnum: string
{
    case DRAFT     = 'draft';
    case EXPIRED   = 'expired';
    case LIVE      = 'live';
    case SCHEDULED = 'scheduled';
}
