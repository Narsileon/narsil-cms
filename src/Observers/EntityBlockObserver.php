<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Elements\Field;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\Relation;
use Narsil\Services\TemplateService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class EntityBlockObserver
{
    #region PUBLIC METHODS

    /**
     * @param EntityBlock $entityBlock
     *
     * @return void
     */
    public function saved(EntityBlock $entityBlock): void
    {
        $this->syncRelations($entityBlock);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param EntityBlock $entityBlock
     *
     * @return void
     */
    protected function syncRelations(EntityBlock $entityBlock): void
    {
        $entityBlock->loadMissing([
            EntityBlock::RELATION_ENTITY,
        ]);

        $entity = $entityBlock->{EntityBlock::RELATION_ENTITY};

        $fields = TemplateService::getBlockFields($entityBlock->{EntityBlock::RELATION_BLOCK});

        foreach ($fields as $field)
        {
            $relations = $entityBlock->{EntityBlock::VALUES}->{$field->{Field::HANDLE}};

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
