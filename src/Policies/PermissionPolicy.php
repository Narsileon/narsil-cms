<?php

namespace Narsil\Policies;

#region USE

use Narsil\Traits\Policies\UpdatableTrait;
use Narsil\Traits\Policies\ViewableTrait;

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
