<?php

namespace Narsil\Enums\SEO;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum ChangeFreqEnum: string
{
    use Enumerable;

    case ALWAYS = 'never';
    case HOURLY = 'current';
    case DAILY = 'others';
    case WEEKLY = 'never';
    case MONTHLY = 'never';
    case YEARLY = 'never';
    case NEVER = 'never';
}
