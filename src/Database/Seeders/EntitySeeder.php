<?php

namespace Narsil\Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Narsil\Models\Collections\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Services\Models\EntityService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class EntitySeeder extends Seeder
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->template = $this->template();
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Template
     */
    protected readonly Template $template;

    #endregion

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
        $entityModel = $this->template->entityClass();

        $locale = Config::get('app.locale');

        $model = $entityModel::query()
            ->where(Entity::SLUG . '->' . $locale, $entity->{Entity::SLUG})
            ->where(Entity::TEMPLATE_ID, $this->template->{Template::ID})
            ->first();

        if ($model)
        {
            return $model;
        }

        $model = $entityModel::create([
            Entity::SLUG => $entity->{Entity::SLUG},
            Entity::TEMPLATE_ID => $this->template->{Template::ID},
        ]);

        $data = $this->data();

        $model->setRelation(Entity::RELATION_TEMPLATE, $this->template);

        EntityService::syncNodes($model, $data);

        return $model;
    }

    #endregion
}
