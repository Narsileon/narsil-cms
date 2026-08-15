<?php

declare(strict_types=1);

namespace Narsil\Cms\Traits;

#region USE

use Illuminate\Database\Eloquent\Collection;
use Narsil\Cms\Models\Entities\EntityNode;

#endregion

trait HasEntityNodeChildren
{
    #region PROTECTED METHODS

    /**
     * Get the children of a node, ordered and read back from the database.
     *
     * Write actions query instead of reading the relation so they never work
     * from a collection a previous step has already made stale.
     *
     * @param EntityNode $node
     *
     * @return Collection<integer,EntityNode>
     */
    protected static function getChildren(EntityNode $node): Collection
    {
        return $node->children()
            ->with([
                EntityNode::RELATION_ELEMENT,
            ])
            ->orderBy(EntityNode::POSITION)
            ->get();
    }

    #endregion
}
