<?php

namespace Narsil\Cms\Policies;

#region USE

use Narsil\Cms\Traits\Policies\CreatableTrait;
use Narsil\Cms\Traits\Policies\DeletableTrait;
use Narsil\Cms\Traits\Policies\UpdatableTrait;
use Narsil\Cms\Traits\Policies\ViewableTrait;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RolePolicy
{
    use CreatableTrait;
    use DeletableTrait;
    use UpdatableTrait;
    use ViewableTrait;
}
