<?php

declare(strict_types=1);

namespace Narsil\Cms\Enums\SEO;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum ChangeFreqEnum: string
{
    use Enumerable;

    case ALWAYS = 'always';
    case HOURLY = 'hourly';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
    case NEVER = 'never';
}
