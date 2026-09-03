<?php

declare(strict_types=1);

namespace Narsil\Cms\Enums\SEO;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum OpenGraphTypeEnum: string
{
    use Enumerable;

    #region CASES

    /**
     * @var string
     */
    case ARTICLE = 'article';
    /**
     * @var string
     */
    case WEBSITE = 'website';

    #endregion
}
