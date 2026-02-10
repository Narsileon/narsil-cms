<?php

namespace Narsil\Cms\Enums;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

/**
 * Enumeration of site page adapters.
 *
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum SitePageAdapterEnum: string
{
    use Enumerable;

    case ENTITY = 'entity';
    case COLLECTION = 'collection';
}
