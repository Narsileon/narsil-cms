<?php

namespace Narsil\Cms\Contracts\Actions\Hosts;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Hosts\Host;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface SyncHostLocales extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Host $host
     * @param array $locales
     *
     * @return Host
     */
    public function run(Host $host, array $locales): Host;

    #endregion
}
