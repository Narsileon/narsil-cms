<?php

namespace Narsil\Cms\Policies;

#region USE

use Narsil\Base\Traits\Policies\IsCreatable;
use Narsil\Base\Traits\Policies\IsDeletable;
use Narsil\Base\Traits\Policies\IsUpdatable;
use Narsil\Base\Traits\Policies\IsViewable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterPolicy
{
    use IsCreatable;
    use IsDeletable;
    use IsUpdatable;
    use IsViewable;
}
