<?php

namespace Narsil\GraphQL\Resolvers;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Narsil\Models\Entities\Relation;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
        $ownerUuid = Arr::get($args, Relation::OWNER_UUID);

        if (empty($ownerTable) || empty($ownerUuid))
        {
            return collect();
        }

        return Relation::entities($ownerTable, $ownerUuid)->get();
    }

    #endregion
}
