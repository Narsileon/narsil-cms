<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Actions\LiveEditor;

#region USE

use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\LiveEditor\DeleteEntityNode as Contract;
use Narsil\Cms\Contracts\Actions\LiveEditor\ReorderEntityNodes;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Traits\HasEntityNodeChildren;

#endregion

class DeleteEntityNode extends Action implements Contract
{
    use HasEntityNodeChildren;

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(EntityNode $node): void
    {
        $nodeClass = $node::class;

        $parent = $nodeClass::query()
            ->firstWhere(EntityNode::UUID, $node->{EntityNode::PARENT_UUID});

        static::deleteSubtree($node);

        if (!$parent)
        {
            return;
        }

        $uuids = static::getChildren($parent)
            ->pluck(EntityNode::UUID)
            ->all();

        app(ReorderEntityNodes::class)->run($parent, $uuids);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param EntityNode $node
     *
     * @return void
     */
    protected static function deleteSubtree(EntityNode $node): void
    {
        foreach (static::getChildren($node) as $child)
        {
            static::deleteSubtree($child);
        }

        $node->relations()->delete();

        $node->delete();
    }

    #endregion
}
