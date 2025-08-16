<?php

namespace Narsil\Resolvers;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class GraphQLResolver
{
    #region PUBLIC METHODS

    /**
     * @param mixed $root
     * @param array $args
     * @param mixed $context
     * @param mixed $resolveInfo
     *
     * @return Collection<int,stdClass>
     */
    public function all(mixed $root, array $args, mixed $context, mixed $resolveInfo): Collection
    {
        $table = $resolveInfo->fieldName;

        return DB::table($table)
            ->get();
    }

    /**
     * @param mixed $root
     * @param array $args
     * @param mixed $context
     * @param mixed $resolveInfo
     *
     * @return Collection<int,stdClass>
     */
    public function find(mixed $root, array $args, mixed $context, mixed $resolveInfo)
    {
        $table = $resolveInfo->fieldName;

        return DB::table($table)
            ->where('id', $args['id'])
            ->first();
    }

    #endregion
}
