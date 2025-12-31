<?php

namespace Narsil\Observers;

#region USE

use Narsil\Contracts\Fields\RelationsField;
use Narsil\Models\Structures\Field;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityField;
use Narsil\Models\Entities\EntityFieldEntity;
use Narsil\Models\Structures\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityFieldObserver
{
    #region PUBLIC METHODS

    /**
     * @param EntityField $entityField
     *
     * @return void
     */
    public function saved(EntityField $entityField): void
    {
        // $this->syncRelations($entityField);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param EntityField $entityField
     *
     * @return void
     */
    protected function syncRelations(EntityField $entityField): void
    {
        $entityField->loadMissing([
            EntityField::RELATION_ELEMENT . '.' . BlockElement::RELATION_FIELD,
            EntityField::RELATION_ENTITY,
        ]);

        $field = $entityField->{EntityField::RELATION_ELEMENT}->{BlockElement::RELATION_FIELD};

        if ($field->{Field::TYPE} !== RelationsField::class)
        {
            return;
        }

        $entity = $entityField->{EntityField::RELATION_ENTITY};

        if ($field->{Field::TRANSLATABLE})
        {
            $translations = $entityField->getTranslations(EntityField::VALUE);

            foreach ($translations as $relations)
            {
                foreach ($relations as $relation)
                {
                    [$table, $id] = explode('-', $relation, 2);

                    EntityFieldEntity::firstOrCreate([
                        EntityFieldEntity::ENTITY_FIELD_UUID => $entityField->{EntityField::UUID},
                        EntityFieldEntity::ENTITY_UUID => $entity->{Entity::ID},
                    ]);
                }
            }
        }
        else
        {
            $relations = $entityField->{EntityField::VALUE};

            foreach ($relations as $relation)
            {
                [$table, $id] = explode('-', $relation, 2);

                EntityFieldEntity::firstOrCreate([
                    EntityFieldEntity::ENTITY_FIELD_UUID => $entityField->{EntityField::UUID},
                    EntityFieldEntity::ENTITY_UUID => $entity->{Entity::ID},
                ]);
            }
        }
    }

    #endregion
}
