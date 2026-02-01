<?php

namespace Narsil\Policies;

#region USE

use Narsil\Traits\Policies\CreatableTrait;
use Narsil\Traits\Policies\DeletableTrait;
use Narsil\Traits\Policies\UpdatableTrait;
use Narsil\Traits\Policies\ViewableTrait;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserPolicy
{
    use CreatableTrait;
    use DeletableTrait;
    use UpdatableTrait;
    use ViewableTrait;
}
