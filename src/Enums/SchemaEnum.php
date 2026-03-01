<?php

namespace Narsil\Cms\Enums;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

/**
 * Enumeration of database schemas.
 *
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum SchemaEnum: string
{
    use Enumerable;

    case DEFAULT = 'cms';
    case DEV = 'cms_dev';
    case LIVE = 'cms_live';
    case STAGE = 'cms_stage';
    case TEST = 'cms_test';
}
