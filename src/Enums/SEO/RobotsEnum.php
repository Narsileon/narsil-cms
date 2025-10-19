<?php

namespace Narsil\Enums\SEO;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum RobotsEnum: string
{
    use Enumerable;

    case ALL = 'index, follow';
    case NOINDEX = 'noindex, follow';
    case NOFOLLOW = 'index, nofollow';
    case NONE = 'noindex, nofollow';
}
