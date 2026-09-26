<?php

declare(strict_types=1);

namespace Narsil\Cms\Traits;

#region USE

use Narsil\Cms\Http\Resources\LiveEditor\EntityNodeTreeResource;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Entities\EntityNodeRelation;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Services\LiveEditor\EntityNodeResolver;

#endregion

trait IsLiveEditorController
{
    #region PROTECTED METHODS

    /**
     * @param SitePage $sitePage
     *
     * @return Entity
     */
    protected function getEntity(SitePage $sitePage): Entity
    {
        $entity = app(EntityNodeResolver::class)->resolveEntity($sitePage);

        if (!$entity)
        {
            abort(404);
        }

        $entity->{Entity::RELATION_NODES}->loadMissing([
            EntityNode::RELATION_BLOCK,
            EntityNode::RELATION_ELEMENT,
            EntityNode::RELATION_RELATIONS . '.' . EntityNodeRelation::RELATION_TARGET,
        ]);

        return $entity;
    }

    /**
     * @param Entity $entity
     * @param string $nodeUuid
     *
     * @return EntityNode
     */
    protected function getNode(Entity $entity, string $nodeUuid): EntityNode
    {
        $node = app(EntityNodeResolver::class)->resolveNode($entity, $nodeUuid);

        if (!$node)
        {
            abort(404);
        }

        return $node;
    }

    /**
     * @param SitePage $sitePage
     *
     * @return EntityNodeTreeResource
     */
    protected function getTree(SitePage $sitePage): EntityNodeTreeResource
    {
        $entity = app(EntityNodeResolver::class)->resolveEntity($sitePage);

        $entity->unsetRelation(Entity::RELATION_NODES);

        return new EntityNodeTreeResource($entity);
    }

    #endregion
}
