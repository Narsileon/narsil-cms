<?php

namespace Narsil\Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Structures\Template;
use Narsil\Services\Models\EntityService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class EntitySeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return Entity
     */
    public function run(): Entity
    {
        $entity = $this->entity();

        return $this->saveEntity($entity);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    abstract protected function data(): array;

    /**
     * @return Entity
     */
    abstract protected function entity(): Entity;

    /**
     * @return Template
     */
    abstract protected function template(): Template;

    /**
     * @param Entity $entity
     *
     * @return Entity
     */
    protected function saveEntity(Entity $entity): Entity
    {
        $template = $this->template();

        $model = Entity::query()
            ->where(Entity::SLUG, $entity->{Entity::SLUG})
            ->where(Entity::TEMPLATE_ID, $template->{Template::ID})
            ->first();

        if ($model)
        {
            return $model;
        }

        $model = Entity::create([
            Entity::SLUG => $entity->{Entity::SLUG},
            Entity::TEMPLATE_ID => $template->{Template::ID},
        ]);

        EntityService::syncNodes($model, $template, $this->data());

        return $model;
    }

    #endregion
}
