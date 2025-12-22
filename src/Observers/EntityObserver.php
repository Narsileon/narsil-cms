<?php

namespace Narsil\Observers;

#region USE

use Narsil\Contracts\Fields\RelationsField;
use Narsil\Models\Elements\Field;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\Relation;
use Narsil\Services\CollectionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityObserver
{
    #region PUBLIC METHODS

    /**
     * @param Entity $entity
     *
     * @return void
     */
    public function deleted(Entity $entity): void
    {
        $this->deleteRelations($entity);
    }

    /**
     * @param Entity $entity
     *
     * @return void
     */
    public function saved(Entity $entity): void
    {
        $this->syncRelations($entity);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Entity $entity
     *
     * @return void
     */
    protected function deleteRelations(Entity $entity): void
    {
        Relation::query()
            ->where(Relation::OWNER_UUID, $entity->{Entity::UUID})
            ->delete();
    }

    /**
     * @param Entity $entity
     *
     * @return void
     */
    protected function syncRelations(Entity $entity): void
    {
        $fields = CollectionService::getTemplateFields($entity::getTemplate(), RelationsField::class);

        foreach ($fields as $field)
        {
            if ($field->{Field::TRANSLATABLE})
            {
                $translations = $entity->getTranslations($field->{Field::HANDLE});

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
                $relations = $entity->{$field->{Field::HANDLE}};

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
    }

    #endregion
}
