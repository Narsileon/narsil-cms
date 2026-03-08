<?php

namespace Narsil\Cms\Contracts\Actions\Entities;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Entities\Entity;

#endregion

/**
 * @author Jonathan Rigaux
 */
interface ReplicateEntity extends Action
{
    #region PUBLIC METHODS

    /**
     * @param Entity $entity
     *
     * @return Entity
     */
    public function run(Entity $entity): Entity;

    #endregion
}
