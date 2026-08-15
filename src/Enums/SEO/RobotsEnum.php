<?php

namespace Narsil\Cms\Enums\SEO;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum RobotsEnum: string
{
    use Enumerable;

    case ALL = 'index, follow';
    case NOINDEX = 'noindex, follow';
    case NOFOLLOW = 'index, nofollow';
    case NONE = 'noindex, nofollow';
}
