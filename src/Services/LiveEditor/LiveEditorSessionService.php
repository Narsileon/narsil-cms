<?php

namespace Narsil\Cms\Services\LiveEditor;

#region USE

use Illuminate\Support\Facades\App;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Services\LocaleService;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Http\Resources\LiveEditor\EntityNodeTreeResource;
use Narsil\Cms\Http\Resources\Sites\SiteResource;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Sites\Site;
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

        $site = $sitePage->{SitePage::RELATION_SITE};
        $country = request()->query(SitePage::COUNTRY, $sitePage->{SitePage::COUNTRY});

        $site?->load([
            Site::RELATION_PAGES => function ($query) use ($sitePage)
            {
                $query->whereIn(SitePage::COUNTRY, [
                    request()->query(SitePage::COUNTRY, $sitePage->{SitePage::COUNTRY}),
                    'default',
                ]);
            },
            Site::RELATION_OTHER_LOCALES,
        ]);

        $siteData = $site ? new SiteResource($site)->resolve() : [];

        return [
            'country' => $country,
            'countries' => $this->countryOptions($site),
            'entityUuid' => $entity?->getKey(),
            'locale' => App::getLocale(),
            'pages' => $siteData[Site::RELATION_PAGES] ?? [],
            'previewUrl' => $this->previewUrl($sitePage),
            'siteLabel' => $site?->{Site::LABEL},
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
            '_country' => $sitePage->{SitePage::COUNTRY},
            '_editor' => 1,
            '_schema' => $this->getCurrentSchema(),
        ]);

        return $siteUrl->{SiteUrl::URL} . '?' . $query;
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Get the countries available for the site.
     *
     * @param Site|null $site
     *
     * @return array<OptionData>
     */
    private function countryOptions(?Site $site): array
    {
        $countries = [
            new OptionData(
                label: trans('narsil-cms::ui.default'),
                value: 'default'
            ),
        ];

        if ($site)
        {
            $otherCountries = $site->{Site::RELATION_OTHER_LOCALES}
                ->pluck('country')
                ->all();

            if (count($otherCountries) > 0)
            {
                $countries = [
                    ...$countries,
                    ...LocaleService::countryOptions($otherCountries),
                ];
            }
        }

        return $countries;
    }

    #endregion
}
