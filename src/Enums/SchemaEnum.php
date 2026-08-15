<?php

namespace Narsil\Cms\Enums;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum SchemaEnum: string
{
    use Enumerable;

    case DEFAULT = 'cms';
    case DEV = 'cms_dev';
    case LIVE = 'cms_live';
    case STAGE = 'cms_stage';
    case TEST = 'cms_test';
}
