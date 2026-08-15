<?php

declare(strict_types=1);

namespace Narsil\Cms\Contracts\Actions\Entities;

#region USE

use Narsil\Base\Contracts\Action;
use Narsil\Cms\Models\Entities\Entity;

#endregion

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
