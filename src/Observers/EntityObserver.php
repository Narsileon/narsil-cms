<?php

namespace Narsil\Observers;

#region USE

use Narsil\Contracts\Fields\RelationsField;
use Narsil\Models\Structures\Field;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityEntity;
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
    protected function syncRelations(Entity $entity): void
    {
        $fields = CollectionService::getTemplateFields($entity->{Entity::RELATION_TEMPLATE}, RelationsField::class);

        foreach ($fields as $field)
        {
            if ($field->{Field::TRANSLATABLE})
            {
                $translations = $entity->getTranslations($field->{Field::HANDLE});

                foreach ($translations as $relations)
                {
                    foreach ($relations as $relation)
                    {
                        EntityEntity::firstOrCreate([
                            EntityEntity::OWNER_UUID => $entity->{Entity::UUID},
                            EntityEntity::TARGET_UUID => $relation,
                        ]);
                    }
                }
            }
            else
            {
                $relations = $entity->{$field->{Field::HANDLE}};

                foreach ($relations as $relation)
                {
                    EntityEntity::firstOrCreate([
                        EntityEntity::OWNER_UUID => $entity->{Entity::UUID},
                        EntityEntity::TARGET_UUID => $relation,
                    ]);
                }
            }
        }
    }

    #endregion
}
