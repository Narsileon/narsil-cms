<?php

namespace Narsil\Cms\Http\Controllers\Sites;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Inertia\Response;
use Locale;
use Narsil\Cms\Casts\HumanDatetimeCast;
use Narsil\Cms\Contracts\Forms\SiteForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Http\Resources\Sites\SiteResource;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\SelectOption;
use Narsil\Cms\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $site
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $site): JsonResponse|Response
    {
        $site = Site::query()
            ->with([
                Site::RELATION_OTHER_LOCALES,
                Site::RELATION_PAGES => function ($query)
                {
                    $query
                        ->whereIn(SitePage::COUNTRY, [
                            Session::get(SitePage::COUNTRY),
                            'default',
                        ]);
                }
            ])
            ->where(Site::HOSTNAME, $site)
            ->first();

        if (!$site)
        {
            abort(404);
        }

        $this->authorize(PermissionEnum::UPDATE, $site);

        $data = $this->getData($site);
        $form = $this->getForm($site);

        $countries = $this->getCountrySelectOptions($site);

        app(TranslationsBag::class)
            ->add('narsil::ui.countries');

        return $this->render('narsil/cms::resources/form', [
            'countries' => $countries,
            'data' => $data,
            'form' => $form,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the country select options.
     *
     * @param Site $site
     *
     * @return array<SelectOption>
     */
    protected function getCountrySelectOptions(Site $site): array
    {
        $options = [
            new SelectOption()
                ->optionLabel(trans('narsil::ui.default'))
                ->optionValue('default')
        ];

        foreach ($site->{Site::RELATION_OTHER_LOCALES} as $locale)
        {
            $label = Locale::getDisplayRegion('_' . $locale->{HostLocale::COUNTRY}, App::getLocale());

            $options[] = new SelectOption()
                ->optionLabel($label)
                ->optionValue($locale->{HostLocale::COUNTRY});
        }

        return $options;
    }

    /**
     * Get the associated data.
     *
     * @param Request $request
     *
     * @return array<string,mixed>
     */
    protected function getData(Site $site): array
    {
        $site->loadMissingCreatorAndEditor();

        $site->mergeCasts([
            Site::CREATED_AT => HumanDatetimeCast::class,
            Site::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = new SiteResource($site)->resolve();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Site::class);
    }

    /**
     * Get the associated form.
     *
     * @param Site $site
     *
     * @return SiteForm
     */
    protected function getForm(Site $site): SiteForm
    {
        $form = app(SiteForm::class)
            ->action(route('sites.update', $site->{Site::HOSTNAME}))
            ->id($site->{Site::ID})
            ->languageOptions(HostLocaleLanguage::getUniqueLanguages())
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Site::class);
    }

    #endregion
}
