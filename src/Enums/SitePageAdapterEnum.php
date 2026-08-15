<?php

declare(strict_types=1);

namespace Narsil\Cms\Enums;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum SitePageAdapterEnum: string
{
    use Enumerable;

    case ENTITY = 'entity';
    case COLLECTION = 'collection';
}
