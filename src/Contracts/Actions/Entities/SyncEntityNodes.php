<?php

namespace Narsil\Cms\Contracts\Actions\Entities;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Entities\Entity;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface SyncEntityNodes extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Entity $entity
     * @param array $attributes
     *
     * @return Entity
     */
    public function run(Entity $hostLocale, array $attributes): Entity;

    #endregion
}
