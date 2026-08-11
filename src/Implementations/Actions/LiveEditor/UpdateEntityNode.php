<?php

namespace Narsil\Cms\Implementations\Actions\LiveEditor;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\LiveEditor\UpdateEntityNode as Contract;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Services\LiveEditor\EntityNodeTreeService;
use Narsil\Cms\Traits\HasEntityNodeChildren;

#endregion

/**
 * @author Jonathan Rigaux
 */
class UpdateEntityNode extends Action implements Contract
{
    use HasEntityNodeChildren;

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     *
     * Only the value nodes belonging to the block are touched, which is why
     * this does not go through SyncEntityNodes: that rebuilds the whole tree
     * from the template and would drop the sibling blocks.
     */
    public function run(EntityNode $node, array $attributes): EntityNode
    {
        $block = $node->block()->first();

        if (!$block)
        {
            return $node;
        }

        if (array_key_exists(EntityNode::ACTIVE, $attributes))
        {
            $node->{EntityNode::ACTIVE} = $attributes[EntityNode::ACTIVE];
            $node->save();
        }

        static::updateElements($node, $block->{Block::RELATION_ELEMENTS}, $attributes);

        return $node;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param EntityNode $parent
     * @param Collection $elements
     * @param array $attributes
     * @param string|null $path
     *
     * @return void
     */
    protected static function updateElements(EntityNode $parent, Collection $elements, array $attributes, ?string $path = null): void
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

            $key = $path ? "$path.$handle" : $handle;

            $node = $children->get($handle);

            if (!$node)
            {
                continue;
            }

            if ($element->{Element::BASE_TYPE} !== Field::TABLE)
            {
                static::updateElements(
                    $node,
                    $element->{Element::RELATION_BASE}->{Block::RELATION_ELEMENTS},
                    $attributes,
                    $key,
                );

                continue;
            }

            if ($element->{Element::RELATION_BASE}->{Field::TYPE} === EntityNodeTreeService::TYPE_BUILDER)
            {
                continue;
            }

            if (!Arr::has($attributes, $key))
            {
                continue;
            }

            $node->{EntityNode::VALUE} = Arr::get($attributes, $key);
            $node->save();
        }
    }

    #endregion
}
