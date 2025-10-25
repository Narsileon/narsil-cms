<?php

namespace Narsil\GraphQL\Resolvers;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Narsil\Models\Entities\Relation;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RelationResolver
{
    #region PUBLIC METHODS

    /**
     * Resolve the recursive relations for a given owner.
     *
     * @param null  $root
     * @param array $args
     *
     * @return Collection
     */
    public function resolveEntities($root, array $args): Collection
    {
        $ownerTable = Arr::get($args, Relation::OWNER_TABLE);
        $ownerId = Arr::get($args, Relation::OWNER_ID);

        if (empty($ownerTable) || empty($ownerId))
        {
            return collect();
        }

        return Relation::entities($ownerTable, $ownerId)->get();
    }

    #endregion
}
