<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Element;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityNode;

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
     * @param array $attributes
     *
     * @return void
     */
    public static function syncNodes(Entity $entity, array $attributes): void
    {
        foreach ($entity->{Entity::RELATION_TEMPLATE}->{Template::RELATION_TABS} as $templateTab)
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
        $entityNodeModel = $entity->{Entity::RELATION_TEMPLATE}->entityNodeClass();

        foreach ($elements as $position => $element)
        {
            $handle = $element->{Element::HANDLE};

            if ($element->{Element::BASE_TYPE} === Field::TABLE)
            {
                $field = $element->{Element::RELATION_BASE};

                $key = $path ? "$path.$handle" : $handle;

                if (!Arr::has($attributes, $key))
                {
                    continue;
                }

                $value = Arr::get($attributes, $key);

                if ($field->{Field::TYPE} === BuilderField::class)
                {
                    $fieldEntityNode = $entityNodeModel::create([
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
                        $blockEntityNode = $entityNodeModel::create([
                            EntityNode::ACTIVE => Arr::get($block, EntityNode::ACTIVE, [
                                Config::get('app.locale') => true,
                            ]),
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
                    $entityNodeModel::create([
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
                $block = $element->{Element::RELATION_BASE};

                if ($block->{Block::VIRTUAL})
                {
                    $nextPath = $path;
                }
                else
                {
                    $nextPath = $path ? "$path.$handle" : $handle;
                }

                $blockEntityNode = $entityNodeModel::create([
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
