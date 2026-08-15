<?php

namespace Narsil\Cms\Enums\SEO;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum OpenGraphTypeEnum: string
{
    use Enumerable;

    case ARTICLE = 'article';
    case WEBSITE = 'website';
}
