<?php

declare(strict_types=1);

namespace Narsil\Cms\Policies;

#region USE

use Narsil\Base\Traits\Policies\IsUpdatable;
use Narsil\Base\Traits\Policies\IsViewable;

#endregion

class SitePolicy
{
    use IsUpdatable;
    use IsViewable;
}
