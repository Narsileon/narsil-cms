<?php

namespace Narsil\Cms\Implementations\Actions\Entities;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Entities\ReplicateEntity as Contract;
use Narsil\Cms\Models\Entities\Entity;

#endregion

/**
 * @author Jonathan Rigaux
 */
class ReplicateEntity extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Entity $entity): Entity
    {
        $replicated = $entity->replicate();

        $replicated
            ->fill([
                //
            ])
            ->save();

        return $replicated;
    }

    #endregion
}
