<?php

namespace Narsil\Cms\Policies;

#region USE

use Narsil\Cms\Traits\Policies\UpdatableTrait;
use Narsil\Cms\Traits\Policies\ViewableTrait;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionPolicy
{
    use UpdatableTrait;
    use ViewableTrait;
}
