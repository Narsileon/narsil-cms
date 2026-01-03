<?php

namespace Narsil\Observers;

#region USE

use Narsil\Contracts\Fields\RelationsField;
use Narsil\Models\Structures\Field;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Entities\EntityNodeEntity;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityNodeObserver
{
    #region PUBLIC METHODS

    /**
     * @param EntityNode $model
     *
     * @return void
     */
    public function saved(EntityNode $model): void
    {
        // $this->syncRelations($EntityNode);
    }

    /**
     * @param EntityNode $model
     *
     * @return void
     */
    public function saving(EntityNode $model): void
    {
        match ($model->{EntityNode::ELEMENT_TYPE})
        {
            BlockElement::TABLE => $model->{EntityNode::BLOCK_ELEMENT_UUID} = $model->{EntityNode::ELEMENT_ID},
            TemplateTabElement::TABLE => $model->{EntityNode::TEMPLATE_TAB_ELEMENT_UUID} = $model->{EntityNode::ELEMENT_ID},
            default => null,
        };
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param EntityNode $EntityNode
     *
     * @return void
     */
    protected function syncRelations(EntityNode $EntityNode): void
    {
        $EntityNode->loadMissing([
            EntityNode::RELATION_ELEMENT . '.' . BlockElement::RELATION_FIELD,
            EntityNode::RELATION_ENTITY,
        ]);

        $field = $EntityNode->{EntityNode::RELATION_ELEMENT}->{BlockElement::RELATION_FIELD};

        if ($field->{Field::TYPE} !== RelationsField::class)
        {
            return;
        }

        $entity = $EntityNode->{EntityNode::RELATION_ENTITY};

        if ($field->{Field::TRANSLATABLE})
        {
            $translations = $EntityNode->getTranslations(EntityNode::VALUE);

            foreach ($translations as $relations)
            {
                foreach ($relations as $relation)
                {
                    [$table, $id] = explode('-', $relation, 2);

                    EntityNodeEntity::firstOrCreate([
                        EntityNodeEntity::ENTITY_NODE_UUID => $EntityNode->{EntityNode::UUID},
                        EntityNodeEntity::ENTITY_UUID => $EntityNode->{EntityNode::ENTITY_UUID},
                        EntityNodeEntity::TARGET_UUID => $entity->{Entity::ID},
                    ]);
                }
            }
        }
        else
        {
            $relations = $EntityNode->{EntityNode::VALUE};

            foreach ($relations as $relation)
            {
                [$table, $id] = explode('-', $relation, 2);

                EntityNodeEntity::firstOrCreate([
                    EntityNodeEntity::ENTITY_NODE_UUID => $EntityNode->{EntityNode::UUID},
                    EntityNodeEntity::ENTITY_UUID => $EntityNode->{EntityNode::ENTITY_UUID},
                    EntityNodeEntity::TARGET_UUID => $entity->{Entity::ID},
                ]);
            }
        }
    }

    #endregion
}
