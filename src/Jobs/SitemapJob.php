<?php

namespace Narsil\Jobs;

#region USE

use Narsil\Models\Hosts\Host;
use Narsil\Support\SitemapIndex;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitemapJob extends AbstractJob
{
    #region CONSTRUCTOR

    /**
     * @param Host $host
     *
     * @return void
     */
    public function __construct(Host $host)
    {
        $this->host = $host;
    }

    #endregion

    #region PROPERTIES

    /**
     * The associated host.
     *
     * @var Host
     */
    protected readonly Host $host;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        new SitemapIndex($this->host)
            ->generate();
    }

    #endregion
}
