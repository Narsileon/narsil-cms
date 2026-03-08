<?php

namespace Narsil\Cms\Policies;

#region USE

use Narsil\Base\Traits\Policies\IsUpdatable;
use Narsil\Base\Traits\Policies\IsViewable;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SitePolicy
{
    use IsUpdatable;
    use IsViewable;
}
