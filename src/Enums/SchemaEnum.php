<?php

declare(strict_types=1);

namespace Narsil\Cms\Enums;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

enum SchemaEnum: string
{
    use Enumerable;

    #region CASES

    /**
     * @var string
     */
    case DEFAULT = 'cms';
    /**
     * @var string
     */
    case DEV = 'cms_dev';
    /**
     * @var string
     */
    case LIVE = 'cms_live';
    /**
     * @var string
     */
    case STAGE = 'cms_stage';
    /**
     * @var string
     */
    case TEST = 'cms_test';

    #endregion
}
