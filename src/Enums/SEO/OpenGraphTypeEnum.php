<?php

namespace Narsil\Enums\SEO;

#region USE

use Narsil\Support\SelectOption;
use Narsil\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum OpenGraphTypeEnum: string
{
    use Enumerable;

    case ARTICLE = 'article';
    case WEBSITE = 'website';
}
