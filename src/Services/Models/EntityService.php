<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\EntityBlockField;

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
     * @param array $blocks
     * @param EntityBlockField|null $parentField
     *
     * @return void
     */
    public static function syncBlocks(Entity $entity, array $blocks, ?EntityBlockField $parentField = null): void
    {
        foreach ($blocks as $key => $block)
        {
            $entityBlock = EntityBlock::create([
                EntityBlock::ENTITY_UUID => $entity->{Entity::UUID},
                EntityBlock::BLOCK_ID => Arr::get($block, EntityBlock::RELATION_BLOCK . '.' . Block::ID),
                EntityBlock::ENTITY_FIELD_UUID => $parentField?->{EntityBlockField::UUID},
                EntityBlock::POSITION => $key,
            ]);

            $elements = Arr::get($block, EntityBlock::RELATION_BLOCK . '.' . Block::RELATION_ELEMENTS, []);

            foreach ($elements as $key => $element)
            {
                $field = Arr::get($block, EntityBlock::RELATION_FIELDS . '.' . $key);

                $entityBlockField = EntityBlockField::create([
                    EntityBlockField::ENTITY_BLOCK_UUID => $entityBlock->{EntityBlock::UUID},
                    EntityBlockField::FIELD_ID => Arr::get($element, BlockElement::ELEMENT_ID),
                    EntityBlockField::VALUE => Arr::get($field, EntityBlockField::VALUE),
                ]);

                if ($childrenBlocks = Arr::get($field, EntityBlockField::RELATION_BLOCKS, []))
                {
                    static::syncBlocks($entity, $childrenBlocks, $entityBlockField);
                }
            }
        }
    }

    #endregion
}
