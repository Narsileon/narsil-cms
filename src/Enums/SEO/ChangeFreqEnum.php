<?php

namespace Narsil\Cms\Enums\SEO;

#region USE

use Narsil\Cms\Traits\Enumerable;

#endregion

/**
 * Enumeration of sitemap change frequencies.
 *
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
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
