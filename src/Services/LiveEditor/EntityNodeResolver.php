<?php

declare(strict_types=1);

namespace Narsil\Cms\Services\LiveEditor;

#region USE

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SitePageEntity;

#endregion

class EntityNodeResolver
{
    #region PUBLIC METHODS

    /**
     * @param SitePage $sitePage
     * @param string|null $language
     *
     * @return Entity|null
     */
    public function resolveEntity(SitePage $sitePage, ?string $language = null): ?Entity
    {
        $sitePage->loadMissing([
            SitePage::RELATION_ENTITIES . '.' . SitePageEntity::RELATION_TARGET,
        ]);

        $entities = $sitePage->{SitePage::RELATION_ENTITIES}->keyBy(SitePageEntity::LANGUAGE);

        $language ??= App::getLocale();

        $sitePageEntity = $entities->get($language, $entities->get(Config::get('app.fallback_locale')));

        return $sitePageEntity?->{SitePageEntity::RELATION_TARGET};
    }

    /**
     * @param Entity $entity
     * @param string $nodeUuid
     *
     * @return EntityNode|null
     */
    public function resolveNode(Entity $entity, string $nodeUuid): ?EntityNode
    {
        return $entity->{Entity::RELATION_NODES}
            ->firstWhere(EntityNode::UUID, $nodeUuid);
    }

    /**
     * @param Entity $entity
     *
     * @return string
     */
    public function resolveNodeClass(Entity $entity): string
    {
        return $entity->{Entity::RELATION_TEMPLATE}->entityNodeClass();
    }

    #endregion
}
