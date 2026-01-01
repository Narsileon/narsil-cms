<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Services\CollectionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class EntityService
{
    #region PUBLIC METHODS

    /**
     * @param Entity $entity
     *
     * @return void
     */
    public static function replicate(Entity $entity): void
    {
        $replicated = $entity->replicate();

        $replicated
            ->fill([
                //
            ])
            ->save();
    }

    /**
     * @param Entity $entity
     * @param Template $template
     * @param array $attributes
     *
     * @return void
     */
    public static function syncNodes(Entity $entity, Template $template, array $attributes): void
    {
        $fieldElements = CollectionService::getFieldElements($template)
            ->keyBy(Field::HANDLE);

        foreach ($attributes as $handle => $value)
        {
            $fieldElement = $fieldElements->get($handle);

            if (!$fieldElement)
            {
                continue;
            }

            if ($fieldElement->{BlockElement::RELATION_ELEMENT}->{Field::TYPE} === BuilderField::class)
            {
                // $EntityNode = EntityNode::create([
                //     EntityNode::ENTITY_UUID  => $entity->{Entity::UUID},
                //     EntityNode::ELEMENT_TYPE => $fieldElement::TABLE,
                //     EntityNode::ELEMENT_ID => $fieldElement->uuid,
                // ]);

                // static::syncFieldBlocks($EntityNode, $value);
            }
            else
            {
                EntityNode::create([
                    EntityNode::ENTITY_UUID  => $entity->{Entity::UUID},
                    EntityNode::ELEMENT_TYPE => $fieldElement::TABLE,
                    EntityNode::ELEMENT_ID => $fieldElement->uuid,
                    EntityNode::VALUE => $value,
                ]);
            }
        }
    }

    /**
     * @param EntityNode $EntityNode
     * @param array $blocks
     *
     * @return void
     */
    public static function syncFieldBlocks(EntityNode $EntityNode, array $blocks): void
    {
        // foreach ($blocks as $key => $block)
        // {
        //     $entityNode = EntityNode::create([
        //         EntityNode::ENTITY_UUID => $EntityNode->{EntityNode::ENTITY_UUID},
        //         EntityNode::BLOCK_ID => Arr::get($block, EntityNode::RELATION_BLOCK . '.' . Block::ID),
        //         EntityNode::ENTITY_NODE_UUID => $EntityNode?->{EntityNode::UUID},
        //         EntityNode::POSITION => $key,
        //     ]);

        //     $elements = Arr::get($block, EntityNode::RELATION_BLOCK . '.' . Block::RELATION_ELEMENTS, []);

        //     foreach ($elements as $key => $element)
        //     {
        //         $field = Arr::get($block, EntityNode::RELATION_FIELDS . '.' . $key);

        //         $nextEntityNode = EntityNode::create([
        //             EntityNode::ENTITY_UUID => $entityNode->{EntityNode::ENTITY_UUID},
        //             EntityNode::ENTITY_BLOCK_UUID => $entityNode->{EntityNode::UUID},
        //             EntityNode::ELEMENT_TYPE => BlockElement::TABLE,
        //             EntityNode::ELEMENT_ID => Arr::get($element, BlockElement::UUID),
        //             EntityNode::VALUE => Arr::get($field, EntityNode::VALUE),
        //         ]);

        //         if ($childrenBlocks = Arr::get($field, EntityNode::RELATION_BLOCKS, []))
        //         {
        //             static::syncFieldBlocks($nextEntityNode, $childrenBlocks);
        //         }
        //     }
        // }
    }

    #endregion
}
