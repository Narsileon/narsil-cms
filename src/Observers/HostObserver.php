<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostPage;

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
        $this->createNavigation($host);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Host $host
     *
     * @return void
     */
    protected function createNavigation(Host $host): void
    {
        HostPage::create([
            HostPage::HOST_ID => $host->{Host::ID},
        ]);
    }

    #endregion
}
