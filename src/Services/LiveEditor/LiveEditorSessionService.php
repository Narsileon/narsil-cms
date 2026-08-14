<?php

namespace Narsil\Cms\Services\LiveEditor;

#region USE

use Illuminate\Support\Facades\App;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Http\Resources\LiveEditor\EntityNodeTreeResource;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SiteUrl;

#endregion

class LiveEditorSessionService
{
    use HasSchemas;

    #region PUBLIC METHODS

    /**
     * Build the payload the editor needs to boot.
     *
     * @param SitePage $sitePage
     *
     * @return array
     */
    public function bootstrap(SitePage $sitePage): array
    {
        $entity = app(EntityNodeResolver::class)->resolveEntity($sitePage);

        $sitePage->loadMissing([
            SitePage::RELATION_SITE,
            SitePage::RELATION_URL,
        ]);

        return [
            'entityUuid' => $entity?->getKey(),
            'locale' => App::getLocale(),
            'previewUrl' => $this->previewUrl($sitePage),
            'siteHostname' => $sitePage->{SitePage::RELATION_SITE}?->{Host::HOSTNAME},
            'sitePageId' => $sitePage->{SitePage::ID},
            'sitePageTitle' => $sitePage->{SitePage::TITLE},
            'tree' => $entity ? new EntityNodeTreeResource($entity) : [],
        ];
    }

    /**
     * Get the public url of a page, flagged so the frontend loads the bridge.
     *
     * The active schema is forwarded so the preview shows the workspace being
     * edited instead of the default one.
     *
     * @param SitePage $sitePage
     *
     * @return string|null
     */
    public function previewUrl(SitePage $sitePage): ?string
    {
        $siteUrl = $sitePage->{SitePage::RELATION_URL};

        if (!$siteUrl)
        {
            return null;
        }

        $query = http_build_query([
            '_editor' => 1,
            '_schema' => $this->getCurrentSchema(),
        ]);

        return $siteUrl->{SiteUrl::URL} . '?' . $query;
    }

    #endregion
}
