<?php

namespace Narsil\Cms\Services\LiveEditor;

#region USE

use Illuminate\Support\Facades\App;
use Narsil\Base\Enums\RequestMethodEnum;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Services\LocaleService;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Contracts\Forms\SitePageForm;
use Narsil\Cms\Http\Resources\LiveEditor\EntityNodeTreeResource;
use Narsil\Cms\Http\Resources\Sites\SiteResource;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SitePageEntity;
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

        $sitePage->loadMissing([
            SitePage::RELATION_ENTITIES . '.' . SitePageEntity::RELATION_TARGET,
        ]);

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
            'pageData' => $this->pageData($sitePage),
            'pageForm' => $this->pageForm($sitePage, $site),
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

    /**
     * Get the page form data.
     *
     * @param SitePage $sitePage
     *
     * @return array
     */
    private function pageData(SitePage $sitePage): array
    {
        $data = $sitePage->toArrayWithTranslations();

        $data[SitePage::RELATION_ENTITIES] = $sitePage->{SitePage::RELATION_ENTITIES}
            ->mapWithKeys(function (SitePageEntity $entity)
            {
                return [
                    $entity->{SitePageEntity::LANGUAGE} => $entity->{SitePageEntity::TARGET_TYPE} . '-' . $entity->{SitePageEntity::TARGET_ID},
                ];
            })
            ->all();

        return $data;
    }

    /**
     * Build the page form.
     *
     * @param SitePage $sitePage
     * @param Site|null $site
     *
     * @return SitePageForm
     */
    private function pageForm(SitePage $sitePage, ?Site $site): SitePageForm
    {
        $options = [
            SitePage::RELATION_ENTITIES => $sitePage->{SitePage::RELATION_ENTITIES}
                ->map(function (SitePageEntity $entity)
                {
                    return $entity->{SitePageEntity::RELATION_TARGET}->toOption();
                })
                ->values()
                ->toArray(),
        ];

        return app(SitePageForm::class)
            ->action(route('sites.pages.update', [
                'site' => $site?->getRouteKey(),
                'sitePage' => $sitePage->{SitePage::ID},
            ]))
            ->id($sitePage->{SitePage::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->options($options)
            ->submitLabel(trans('narsil::ui.update'));
    }

    #endregion
}
