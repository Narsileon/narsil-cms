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
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostPage;
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
        $host = Host::query()
            ->with([
                Host::RELATION_OTHER_LOCALES,
                Host::RELATION_PAGES => function ($query)
                {
                    $query
                        ->whereDoesntHave(HostPage::RELATION_LOCALE)
                        ->orWhereHas(HostPage::RELATION_LOCALE, function ($subquery)
                        {
                            $subquery->where(HostLocale::COUNTRY, Session::get(HostLocale::COUNTRY));
                        });
                },
                Host::RELATION_PAGES . '.' . HostPage::RELATION_LOCALE,
            ])
            ->where(Host::HANDLE, $site)
            ->first();

        if (!$host)
        {
            abort(404);
        }

        $this->authorize(PermissionEnum::UPDATE, $host);

        $data = $this->getData($host);
        $form = $this->getForm($host)
            ->formData($data);

        $countries = $this->getCountrySelectOptions($host);

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
     * @param Host $host
     *
     * @return array<SelectOption>
     */
    protected function getCountrySelectOptions(Host $host): array
    {
        $options = [
            new SelectOption()
                ->optionLabel(trans('narsil::ui.default'))
                ->optionValue('default')
        ];

        foreach ($host->{Host::RELATION_OTHER_LOCALES} as $locale)
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
    protected function getData(Host $host): array
    {
        $host->loadMissingCreatorAndEditor();

        $host->mergeCasts([
            Host::CREATED_AT => HumanDatetimeCast::class,
            Host::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = new SiteResource($host)->resolve();

        return $data;
    }

    /**
     * Get the associated form.
     *
     * @param Host $host
     *
     * @return SiteForm
     */
    protected function getForm(Host $host): SiteForm
    {
        $form = app(SiteForm::class)
            ->action(route('sites.update', $host->{Host::HANDLE}))
            ->id($host->{Host::ID})
            ->method(MethodEnum::PATCH->value)
            ->languageOptions([])
            ->submitLabel(trans('narsil::ui.update'))
            ->title($host->{Host::NAME});

        return $form;
    }

    #endregion
}
