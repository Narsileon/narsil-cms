<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Arr;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
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
    public static function replicateEntity(Entity $entity): void
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
     * @param EntityBlock|null $parent
     *
     * @return void
     */
    public static function syncBlocks(Entity $entity, array $blocks, ?EntityBlock $parent = null): void
    {
        foreach ($blocks as $key => $block)
        {
            $entityBlock = EntityBlock::create([
                EntityBlock::ENTITY_UUID => $entity->{Entity::UUID},
                EntityBlock::BLOCK_ID => Arr::get($block, EntityBlock::RELATION_BLOCK . '.' . Block::ID),
                EntityBlock::PARENT_UUID => $parent?->{EntityBlock::UUID},
                EntityBlock::POSITION => $key,
            ]);

            $elements = Arr::get($block, EntityBlock::RELATION_BLOCK . '.' . Block::RELATION_ELEMENTS, []);

            foreach ($elements as $key => $element)
            {
                EntityBlockField::create([
                    EntityBlockField::ENTITY_BLOCK_UUID => $entityBlock->{EntityBlock::UUID},
                    EntityBlockField::FIELD_ID => Arr::get($element, BlockElement::ELEMENT_ID),
                    EntityBlockField::VALUE => Arr::get($block, EntityBlock::RELATION_FIELDS . '.' . $key . '.' . EntityBlockField::VALUE),
                ]);
            }

            if ($children = Arr::get($block, EntityBlock::RELATION_CHILDREN))
            {
                static::syncBlocks($entity, $children, $entityBlock);
            }
        }
    }

    #endregion
}
