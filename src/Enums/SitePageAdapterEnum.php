<?php

declare(strict_types=1);

namespace Narsil\Cms\Enums;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum SitePageAdapterEnum: string
{
    use Enumerable;

    #region CASES

    /**
     * @var string
     */
    case ENTITY = 'entity';
    /**
     * @var string
     */
    case COLLECTION = 'collection';

    #endregion
}
