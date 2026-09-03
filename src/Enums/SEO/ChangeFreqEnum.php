<?php

declare(strict_types=1);

namespace Narsil\Cms\Enums\SEO;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum ChangeFreqEnum: string
{
    use Enumerable;

    #region CASES

    /**
     * @var string
     */
    case ALWAYS = 'always';
    /**
     * @var string
     */
    case HOURLY = 'hourly';
    /**
     * @var string
     */
    case DAILY = 'daily';
    /**
     * @var string
     */
    case WEEKLY = 'weekly';
    /**
     * @var string
     */
    case MONTHLY = 'monthly';
    /**
     * @var string
     */
    case YEARLY = 'yearly';
    /**
     * @var string
     */
    case NEVER = 'never';

    #endregion
}
