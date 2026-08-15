<?php

declare(strict_types=1);

namespace Narsil\Cms\Policies;

#region USE

use Narsil\Base\Traits\Policies\IsCreatable;
use Narsil\Base\Traits\Policies\IsDeletable;
use Narsil\Base\Traits\Policies\IsUpdatable;
use Narsil\Base\Traits\Policies\IsViewable;

#endregion

class BlockPolicy
{
    use IsCreatable;
    use IsDeletable;
    use IsUpdatable;
    use IsViewable;
}
