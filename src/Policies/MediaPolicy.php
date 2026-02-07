<?php

namespace Narsil\Cms\Policies;

#region USE

use Narsil\Cms\Traits\Policies\IsCreatable;
use Narsil\Cms\Traits\Policies\IsDeletable;
use Narsil\Cms\Traits\Policies\IsUpdatable;
use Narsil\Cms\Traits\Policies\IsViewable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaPolicy
{
    use IsCreatable;
    use IsDeletable;
    use IsUpdatable;
    use IsViewable;
}
