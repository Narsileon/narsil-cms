<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Interfaces\IStructureHasElement;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTab;

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
        foreach ($template->{Template::RELATION_TABS} as $templateTab)
        {
            static::syncElements($entity, $templateTab->{TemplateTab::RELATION_ELEMENTS}, $attributes);
        }
    }

    /**
     * @param Entity $entity
     * @param Collection $elements
     * @param array $attributes
     * @param EntityNode|null $parent
     * @param string|null $path
     *
     * @return void
     */
    public static function syncElements(Entity $entity, Collection $elements, array $attributes, ?EntityNode $parent = null, ?string $path = null): void
    {
        foreach ($elements as $position => $element)
        {
            $handle = $element->{IStructureHasElement::HANDLE};

            if ($element->{IStructureHasElement::ELEMENT_TYPE} === Field::TABLE)
            {
                $field = $element->{IStructureHasElement::RELATION_ELEMENT};

                $key = $path ? "$path.$handle" : $handle;

                if (!Arr::has($attributes, $key))
                {
                    continue;
                }

                $value = Arr::get($attributes, $key);

                if ($field->{Field::TYPE} === BuilderField::class)
                {
                    $fieldEntityNode = EntityNode::create([
                        EntityNode::ELEMENT_ID => $element->getKey(),
                        EntityNode::ELEMENT_TYPE => $element->getTable(),
                        EntityNode::OWNER_UUID  => $entity->{Entity::UUID},
                        EntityNode::PARENT_UUID => $parent ? $parent->getKey() : null,
                        EntityNode::PATH => $key,
                    ]);

                    if (!is_array($value))
                    {
                        continue;
                    }

                    foreach ($value as $index => $block)
                    {
                        $blockEntityNode = EntityNode::create([
                            EntityNode::BLOCK_ID => Arr::get($block, EntityNode::BLOCK_ID),
                            EntityNode::OWNER_UUID => $entity->{Entity::UUID},
                            EntityNode::PARENT_UUID => $fieldEntityNode->getKey(),
                            EntityNode::PATH => "$key.$index",
                            EntityNode::POSITION => $index,
                        ]);

                        $blockEntityNode->loadMissing([
                            EntityNode::RELATION_BLOCK,
                        ]);

                        $nextPath = "$key.$index." . EntityNode::RELATION_CHILDREN;

                        static::syncElements($entity, $blockEntityNode->{EntityNode::RELATION_BLOCK}->{Block::RELATION_ELEMENTS}, $attributes, $blockEntityNode, $nextPath);
                    }
                }
                else
                {
                    EntityNode::create([
                        EntityNode::ELEMENT_ID => $element->getKey(),
                        EntityNode::ELEMENT_TYPE => $element->getTable(),
                        EntityNode::OWNER_UUID  => $entity->{Entity::UUID},
                        EntityNode::PARENT_UUID => $parent ? $parent->getKey() : null,
                        EntityNode::PATH => $key,
                        EntityNode::POSITION => $position,
                        EntityNode::VALUE => $value,
                    ]);
                }
            }
            else
            {
                $block = $element->{IStructureHasElement::RELATION_ELEMENT};

                if ($block->{Block::VIRTUAL})
                {
                    $nextPath = $path;
                }
                else
                {
                    $nextPath = $path ? "$path.$handle" : $handle;
                }

                $blockEntityNode = EntityNode::create([
                    EntityNode::ELEMENT_ID => $element->getKey(),
                    EntityNode::ELEMENT_TYPE => $element->getTable(),
                    EntityNode::OWNER_UUID  => $entity->{Entity::UUID},
                    EntityNode::PARENT_UUID => $parent ? $parent->getKey() : null,
                    EntityNode::PATH => $nextPath,
                    EntityNode::POSITION => $position,
                ]);

                static::syncElements($entity, $block->{Block::RELATION_ELEMENTS}, $attributes, $blockEntityNode, $nextPath);
            }
        }
    }

    #endregion
}
