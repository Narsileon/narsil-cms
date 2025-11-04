<?php

namespace Narsil\Http\Controllers\Sites;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Inertia\Response;
use Locale;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\SiteForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Resources\Sites\SiteResource;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Sites\Site;
use Narsil\Support\SelectOption;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteEditController extends AbstractController
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
            ->where(Site::HANDLE, $site)
            ->first();

        if (!$site)
        {
            abort(404);
        }

        $this->authorize(PermissionEnum::UPDATE, $site);

        $data = $this->getData($site);
        $form = $this->getForm($site)
            ->formData($data);

        $countries = $this->getCountrySelectOptions($site);

        app(TranslationsBag::class)
            ->add('narsil::ui.countries');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: [
                ...$form->jsonSerialize(),
                'countries' => $countries,
            ],
        );
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
     * Get the associated form.
     *
     * @param Site $site
     *
     * @return SiteForm
     */
    protected function getForm(Site $site): SiteForm
    {
        $form = app(SiteForm::class)
            ->action(route('sites.update', $site->{Site::HANDLE}))
            ->id($site->{Site::ID})
            ->method(MethodEnum::PATCH->value)
            ->languageOptions([])
            ->submitLabel(trans('narsil::ui.update'))
            ->title($site->{Site::NAME});

        return $form;
    }

    #endregion
}
