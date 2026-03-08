<?php

namespace Narsil\Cms\Contracts\Actions\Hosts;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Hosts\Host;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface ReplicateHost extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Host $host
     *
     * @return Host
     */
    public function run(Host $host): Host;

    #endregion
}
