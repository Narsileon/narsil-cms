<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Actions\LiveEditor;

#region USE

use Illuminate\Support\Collection;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\LiveEditor\ReorderEntityNodes as Contract;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Services\LiveEditor\EntityNodeTreeService;
use Narsil\Cms\Traits\HasEntityNodeChildren;

#endregion

class ReorderEntityNodes extends Action implements Contract
{
    use HasEntityNodeChildren;

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(EntityNode $parent, array $orderedUuids): void
    {
        $children = static::getChildren($parent)->keyBy(EntityNode::UUID);

        $parentPath = $parent->{EntityNode::PATH};

        $position = 0;

        foreach ($orderedUuids as $uuid)
        {
            $node = $children->get($uuid);

            if (!$node)
            {
                continue;
            }

            static::moveBlockNode($node, $parentPath, $position);

            $position++;
        }
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Move a block node to a position and realign the paths of its subtree.
     *
     * @param EntityNode $node
     * @param string|null $parentPath
     * @param integer $position
     *
     * @return void
     */
    protected static function moveBlockNode(EntityNode $node, ?string $parentPath, int $position): void
    {
        $node->{EntityNode::POSITION} = $position;
        $node->{EntityNode::PATH} = $parentPath ? "$parentPath.$position" : (string)$position;

        $node->save();

        $block = $node->block()->first();

        if (!$block)
        {
            return;
        }

        static::syncElementPaths(
            $node,
            $block->{Block::RELATION_ELEMENTS},
            $node->{EntityNode::PATH} . '.' . EntityNode::RELATION_CHILDREN,
        );
    }

    /**
     * @param EntityNode $parent
     * @param Collection $elements
     * @param string|null $path
     *
     * @return void
     */
    protected static function syncElementPaths(EntityNode $parent, Collection $elements, ?string $path): void
    {
        $children = static::getChildren($parent)
            ->filter(function (EntityNode $node)
            {
                return $node->{EntityNode::RELATION_ELEMENT} !== null;
            })
            ->keyBy(function (EntityNode $node)
            {
                return $node->{EntityNode::RELATION_ELEMENT}->{Element::HANDLE};
            });

        foreach ($elements as $element)
        {
            $handle = $element->{Element::HANDLE};

            $node = $children->get($handle);

            if (!$node)
            {
                continue;
            }

            if ($element->{Element::BASE_TYPE} === Field::TABLE)
            {
                $key = $path ? "$path.$handle" : $handle;

                $node->{EntityNode::PATH} = $key;
                $node->save();

                if ($element->{Element::RELATION_BASE}->{Field::TYPE} === EntityNodeTreeService::TYPE_BUILDER)
                {
                    $position = 0;

                    foreach (static::getChildren($node) as $blockNode)
                    {
                        static::moveBlockNode($blockNode, $key, $position);

                        $position++;
                    }
                }

                continue;
            }

            $base = $element->{Element::RELATION_BASE};

            $nextPath = $base->{Block::VIRTUAL} ? $path : ($path ? "$path.$handle" : $handle);

            $node->{EntityNode::PATH} = $nextPath;
            $node->save();

            static::syncElementPaths($node, $base->{Block::RELATION_ELEMENTS}, $nextPath);
        }
    }

    #endregion
}
