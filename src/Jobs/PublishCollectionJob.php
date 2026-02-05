<?php

namespace Narsil\Cms\Jobs;

#region USE

use Carbon\Carbon;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PublishCollectionJob extends AbstractJob
{
    #region CONSTRUCTOR

    /**
     * @param Template $template
     *
     * @return void
     */
    public function __construct(Template $template)
    {
        $this->template = $template;

        parent::__construct();
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Template
     */
    protected Template $template;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        $now = Carbon::now();

        $model = $this->template->entityClass();

        $model::withTrashed()
            ->where(Entity::REVISION, '>', 0)
            ->where(Entity::PUBLISHED, false)
            ->whereNotNull(Entity::PUBLISHED_FROM)
            ->where(Entity::PUBLISHED_FROM, '<=', $now)
            ->update([
                Entity::PUBLISHED => true,
            ]);

        $model::withTrashed()
            ->where(Entity::REVISION, '>', 0)
            ->where(Entity::PUBLISHED, true)
            ->whereNotNull(Entity::PUBLISHED_TO)
            ->where(Entity::PUBLISHED_TO, '<=', $now)
            ->update([
                Entity::PUBLISHED => false,
            ]);
    }

    #endregion
}
