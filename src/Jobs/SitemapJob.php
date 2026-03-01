<?php

namespace Narsil\Cms\Jobs;

#region USE

use Narsil\Base\Jobs\Job;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Support\SitemapIndex;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitemapJob extends Job
{
    use HasSchemas;

    #region CONSTRUCTOR

    /**
     * @param Host $host
     *
     * @return void
     */
    public function __construct(Host $host, string $schema)
    {
        $this->host = $host;
        $this->schema = $schema;
    }

    #endregion

    #region PROPERTIES

    /**
     * The associated host.
     *
     * @var Host
     */
    protected readonly Host $host;

    /**
     * The associated schema.
     *
     * @var string
     */
    protected readonly string $schema;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        $this->setSearchPath($this->schema);

        new SitemapIndex($this->host)
            ->generate();
    }

    #endregion
}
