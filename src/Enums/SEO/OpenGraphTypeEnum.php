<?php

namespace Narsil\Cms\Enums\SEO;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

/**
 * Enumeration of open graph types.
 *
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum OpenGraphTypeEnum: string
{
    use Enumerable;

    case ARTICLE = 'article';
    case WEBSITE = 'website';
}
