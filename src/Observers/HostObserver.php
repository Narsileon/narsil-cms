<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Hosts\Host;
use Narsil\Models\Sites\Site;

#endregion


/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class HostObserver
{
    #region PUBLIC METHODS

    /**
     * @param Host $host
     *
     * @return void
     */
    public function created(Host $host): void
    {
        $this->createSite($host);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Create the site associated to the host.
     *
     * @param Host $host
     *
     * @return void
     */
    protected function createSite(Host $host): void
    {
        Site::create([
            Site::HOST_ID => $host->{Host::ID},
        ]);
    }

    #endregion
}
