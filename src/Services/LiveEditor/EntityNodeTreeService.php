<?php

namespace Narsil\Cms\Services\LiveEditor;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;

#endregion

/**
 * @author Jonathan Rigaux
 */
class EntityNodeTreeService
{
    #region CONSTANTS

    /**
     * The type of a builder container node.
     *
     * @var string
     */
    final public const TYPE_BUILDER = 'builder';

    /**
     * The type of a block instance node.
     *
     * @var string
     */
    final public const TYPE_BLOCK = 'block';

    #endregion

    #region PROPERTIES

    /**
     * The nodes of the entity grouped by parent uuid.
     *
     * @var Collection<string,Collection<integer,EntityNode>>
     */
    private Collection $nodes;

    #endregion

    #region PUBLIC METHODS

    /**
     * Build the content tree of an entity.
     *
     * The tree only contains builder containers and the block instances they
     * hold. Value nodes are edited through the inspector instead.
     *
     * @param Entity $entity
     *
     * @return array
     */
    public function build(Entity $entity): array
    {
        $nodes = $entity->{Entity::RELATION_NODES};

        $nodes->loadMissing([
            EntityNode::RELATION_BLOCK,
            EntityNode::RELATION_ELEMENT,
        ]);

        $this->nodes = $nodes->groupBy(EntityNode::PARENT_UUID);

        return $this->processNodes();
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param string|null $parentUuid
     *
     * @return array
     */
    private function processNodes(?string $parentUuid = null): array
    {
        $nodes = $this->nodes->get($parentUuid, collect())->sortBy(EntityNode::POSITION);

        $tree = [];

        foreach ($nodes as $node)
        {
            if ($node->{EntityNode::BLOCK_ID})
            {
                $tree[] = $this->blockNode($node);

                continue;
            }

            $element = $node->{EntityNode::RELATION_ELEMENT};

            if (!$element)
            {
                continue;
            }

            if ($element->{Element::BASE_TYPE} !== Field::TABLE)
            {
                $tree = array_merge($tree, $this->processNodes($node->{EntityNode::UUID}));

                continue;
            }

            $field = $element->{Element::RELATION_BASE};

            if ($field->{Field::TYPE} === self::TYPE_BUILDER)
            {
                $tree[] = $this->builderNode($node, $element, $field);
            }
        }

        return $tree;
    }

    /**
     * @param EntityNode $node
     *
     * @return array
     */
    private function blockNode(EntityNode $node): array
    {
        $block = $node->{EntityNode::RELATION_BLOCK};

        return [
            'active' => $node->getTranslationWithFallback(EntityNode::ACTIVE, App::getLocale()) !== false,
            'children' => $this->processNodes($node->{EntityNode::UUID}),
            'handle' => $block?->{Block::HANDLE},
            'id' => $node->{EntityNode::UUID},
            'label' => $block?->{Block::LABEL},
            'meta' => [
                'canAddChild' => false,
                'canDelete' => true,
                'canDrag' => true,
                'selectable' => true,
            ],
            'parent_id' => $node->{EntityNode::PARENT_UUID},
            'position' => $node->{EntityNode::POSITION},
            'type' => self::TYPE_BLOCK,
        ];
    }

    /**
     * @param EntityNode $node
     * @param Element $element
     * @param Field $field
     *
     * @return array
     */
    private function builderNode(EntityNode $node, Element $element, Field $field): array
    {
        return [
            'allowedBlocks' => $field->{Field::RELATION_BLOCKS}
                ->map(function (Block $block)
                {
                    return [
                        'block_id' => $block->{Block::ID},
                        'handle' => $block->{Block::HANDLE},
                        'icon' => $block->{Block::ATTRIBUTE_ICON},
                        'label' => $block->{Block::LABEL},
                    ];
                })
                ->values()
                ->all(),
            'children' => $this->processNodes($node->{EntityNode::UUID}),
            'id' => $node->{EntityNode::UUID},
            'label' => $element->{Element::LABEL} ?? $field->{Field::LABEL},
            'meta' => [
                'canAddChild' => true,
                'canDelete' => false,
                'canDrag' => false,
                'selectable' => false,
            ],
            'parent_id' => $node->{EntityNode::PARENT_UUID},
            'position' => $node->{EntityNode::POSITION},
            'type' => self::TYPE_BUILDER,
        ];
    }

    #endregion
}
