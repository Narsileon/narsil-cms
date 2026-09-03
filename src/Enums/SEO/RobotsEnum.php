<?php

declare(strict_types=1);

namespace Narsil\Cms\Enums\SEO;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum RobotsEnum: string
{
    use Enumerable;

    #region CASES

    /**
     * @var string
     */
    case ALL = 'index, follow';
    /**
     * @var string
     */
    case NOINDEX = 'noindex, follow';
    /**
     * @var string
     */
    case NOFOLLOW = 'index, nofollow';
    /**
     * @var string
     */
    case NONE = 'noindex, nofollow';

    #endregion
}
