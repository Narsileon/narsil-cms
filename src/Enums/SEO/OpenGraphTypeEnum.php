<?php

namespace Narsil\Enums\SEO;

#region USE

use Narsil\Support\SelectOption;
use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
enum OpenGraphTypeEnum: string
{
    use Enumerable;

    case ARTICLE = 'article';
    case WEBSITE = 'website';
}
