<?php

namespace Narsil\Cms\Implementations\Actions\LiveEditor;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\LiveEditor\CreateEntityBlockNode as Contract;
use Narsil\Cms\Contracts\Actions\LiveEditor\ReorderEntityNodes;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Traits\HasEntityNodeChildren;

#endregion

/**
 * @author Jonathan Rigaux
 */
class CreateEntityBlockNode extends Action implements Contract
{
    use HasEntityNodeChildren;

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(EntityNode $parent, int $blockId, ?int $position = null): EntityNode
    {
        $block = Block::query()->findOrFail($blockId);

        $siblings = static::getChildren($parent);

        $position = max(0, min($position ?? $siblings->count(), $siblings->count()));

        $node = static::createNode($parent, [
            EntityNode::ACTIVE => [
                Config::get('app.locale') => true,
            ],
            EntityNode::BLOCK_ID => $blockId,
            EntityNode::POSITION => $position,
        ]);

        static::createElements($node, $block->{Block::RELATION_ELEMENTS});

        $uuids = $siblings->pluck(EntityNode::UUID)->all();

        array_splice($uuids, $position, 0, [$node->getKey()]);

        app(ReorderEntityNodes::class)->run($parent, $uuids);

        return $node->refresh();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Create the value nodes mirroring the elements of a block.
     *
     * @param EntityNode $parent
     * @param Collection $elements
     *
     * @return void
     */
    protected static function createElements(EntityNode $parent, Collection $elements): void
    {
        foreach ($elements as $position => $element)
        {
            $node = static::createNode($parent, [
                EntityNode::ELEMENT_ID => $element->getKey(),
                EntityNode::ELEMENT_TYPE => $element->getTable(),
                EntityNode::POSITION => $position,
            ]);

            if ($element->{Element::BASE_TYPE} === Field::TABLE)
            {
                continue;
            }

            static::createElements($node, $element->{Element::RELATION_BASE}->{Block::RELATION_ELEMENTS});
        }
    }

    /**
     * @param EntityNode $parent
     * @param array $attributes
     *
     * @return EntityNode
     */
    protected static function createNode(EntityNode $parent, array $attributes): EntityNode
    {
        $nodeClass = $parent::class;

        return $nodeClass::create([
            ...$attributes,
            EntityNode::OWNER_UUID => $parent->{EntityNode::OWNER_UUID},
            EntityNode::PARENT_UUID => $parent->getKey(),
        ]);
    }

    #endregion
}
