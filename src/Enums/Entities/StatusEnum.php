<?php

namespace Narsil\Enums\Entities;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum StatusEnum: string
{
    use Enumerable;

    case DRAFT = 'draft';
    case EXPIRED = 'expired';
    case LIVE = 'live';
    case SCHEDULED = 'scheduled';
}
