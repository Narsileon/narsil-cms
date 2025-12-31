<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\EntityBlockField;
use Narsil\Models\Entities\EntityField;
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
    public static function syncFields(Entity $entity, Template $template, array $attributes): void
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
                $entityField = EntityField::create([
                    EntityField::ENTITY_UUID  => $entity->{Entity::UUID},
                    EntityField::ELEMENT_TYPE => $fieldElement::class,
                    EntityField::ELEMENT_ID => $fieldElement->uuid,
                ]);

                static::syncFieldBlocks($entityField, $value);
            }
            else
            {
                EntityField::create([
                    EntityField::ENTITY_UUID  => $entity->{Entity::UUID},
                    EntityField::ELEMENT_TYPE => $fieldElement::class,
                    EntityField::ELEMENT_ID => $fieldElement->uuid,
                    EntityField::VALUE => $value,
                ]);
            }
        }
    }

    /**
     * @param EntityField $entityField
     * @param array $blocks
     *
     * @return void
     */
    public static function syncFieldBlocks(EntityField $entityField, array $blocks): void
    {
        foreach ($blocks as $key => $block)
        {
            $entityBlock = EntityBlock::create([
                EntityBlock::ENTITY_UUID => $entityField->{EntityField::ENTITY_UUID},
                EntityBlock::BLOCK_ID => Arr::get($block, EntityBlock::RELATION_BLOCK . '.' . Block::ID),
                EntityBlock::ENTITY_FIELD_UUID => $entityField?->{EntityField::UUID},
                EntityBlock::POSITION => $key,
            ]);

            $elements = Arr::get($block, EntityBlock::RELATION_BLOCK . '.' . Block::RELATION_ELEMENTS, []);

            foreach ($elements as $key => $element)
            {
                $field = Arr::get($block, EntityBlock::RELATION_FIELDS . '.' . $key);

                $nextEntityField = EntityField::create([
                    EntityField::ENTITY_UUID => $entityBlock->{EntityBlock::ENTITY_UUID},
                    EntityField::ENTITY_BLOCK_UUID => $entityBlock->{EntityBlock::UUID},
                    EntityField::ELEMENT_TYPE => BlockElement::class,
                    EntityField::ELEMENT_ID => Arr::get($element, BlockElement::UUID),
                    EntityField::VALUE => Arr::get($field, EntityField::VALUE),
                ]);

                if ($childrenBlocks = Arr::get($field, EntityField::RELATION_BLOCKS, []))
                {
                    static::syncFieldBlocks($nextEntityField, $childrenBlocks);
                }
            }
        }
    }

    #endregion
}
