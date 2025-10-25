<?php

namespace Narsil\Enums\SEO;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * Enumeration of robots meta tag directives.
 *
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum RobotsEnum: string
{
    use Enumerable;

    case ALL = 'index, follow';
    case NOINDEX = 'noindex, follow';
    case NOFOLLOW = 'index, nofollow';
    case NONE = 'noindex, nofollow';
}
