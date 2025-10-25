<?php

namespace Narsil\Observers;

#region USE

use Narsil\Contracts\Fields\RelationsField;
use Narsil\Models\Elements\Field;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\EntityBlockField;
use Narsil\Models\Entities\Relation;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityBlockFieldObserver
{
    #region PUBLIC METHODS

    /**
     * @param EntityBlockField $entityBlockField
     *
     * @return void
     */
    public function saved(EntityBlockField $entityBlockField): void
    {
        $this->syncRelations($entityBlockField);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param EntityBlockField $entityBlockField
     *
     * @return void
     */
    protected function syncRelations(EntityBlockField $entityBlockField): void
    {
        $entityBlockField->loadMissing([
            EntityBlockField::RELATION_FIELD,
            EntityBlockField::RELATION_BLOCK . '.' . EntityBlock::RELATION_ENTITY,
        ]);

        $field = $entityBlockField->{EntityBlockField::RELATION_FIELD};

        if ($field->{Field::TYPE} !== RelationsField::class)
        {
            return;
        }

        $entity = $entityBlockField->{EntityBlockField::RELATION_BLOCK}?->{EntityBlock::RELATION_ENTITY};

        if ($field->{Field::TRANSLATABLE})
        {
            $translations = $entityBlockField->getTranslations(EntityBlockField::VALUE);

            foreach ($translations as $relations)
            {
                foreach ($relations as $relation)
                {
                    [$table, $id] = explode('-', $relation, 2);

                    Relation::firstOrCreate([
                        Relation::OWNER_ID => $entity->{Entity::ID},
                        Relation::OWNER_TABLE => $entity->getTable(),
                        Relation::OWNER_UUID => $entity->{Entity::UUID},
                        Relation::TARGET_ID => $id,
                        Relation::TARGET_TABLE => $table,
                    ]);
                }
            }
        }
        else
        {
            $relations = $entityBlockField->{EntityBlockField::VALUE};

            foreach ($relations as $relation)
            {
                [$table, $id] = explode('-', $relation, 2);

                Relation::firstOrCreate([
                    Relation::OWNER_ID => $entity->{Entity::ID},
                    Relation::OWNER_TABLE => $entity->getTable(),
                    Relation::OWNER_UUID => $entity->{Entity::UUID},
                    Relation::TARGET_ID => $id,
                    Relation::TARGET_TABLE => $table,
                ]);
            }
        }
    }

    #endregion
}
