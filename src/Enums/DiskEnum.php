<?php

namespace Narsil\Cms\Enums;

#region USE

use Narsil\Base\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum DiskEnum: string
{
    use Enumerable;

    case DOCUMENTS = 'documents';
    case IMAGES = 'images';
    case VIDEOS = 'videos';
}
