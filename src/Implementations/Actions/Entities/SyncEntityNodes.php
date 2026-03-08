<?php

namespace Narsil\Cms\Implementations\Actions\Entities;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Entities\SyncEntityNodes as Contract;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncEntityNodes extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Entity $entity, array $attributes): Entity
    {
        foreach ($entity->{Entity::RELATION_TEMPLATE}->{Template::RELATION_TABS} as $templateTab)
        {
            static::syncElements($entity, $templateTab->{TemplateTab::RELATION_ELEMENTS}, $attributes);
        }

        return $entity;
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @param Entity $entity
     * @param Collection $elements
     * @param array $attributes
     * @param EntityNode|null $parent
     * @param string|null $path
     *
     * @return void
     */
    private static function syncElements(Entity $entity, Collection $elements, array $attributes, ?EntityNode $parent = null, ?string $path = null): void
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

                if ($field->{Field::TYPE} === 'builder')
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
