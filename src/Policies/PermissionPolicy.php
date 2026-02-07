<?php

namespace Narsil\Cms\Policies;

#region USE

use Narsil\Cms\Traits\Policies\IsUpdatable;
use Narsil\Cms\Traits\Policies\IsViewable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionPolicy
{
    use IsUpdatable;
    use IsViewable;
}
