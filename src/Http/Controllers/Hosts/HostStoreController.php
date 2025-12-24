<?php

namespace Narsil\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\HostFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Services\Models\HostLocaleService;
use Narsil\Services\Models\HostService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Host::class);

        $data = $request->all();

        $rules = app(HostFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $host = Host::create($attributes);

        if ($defaultLocale = Arr::get($attributes, Host::RELATION_DEFAULT_LOCALE))
        {
            $hostLocale = HostLocale::create([
                HostLocale::PATTERN  => Arr::get($defaultLocale, HostLocale::PATTERN),
            ]);

            HostLocaleService::syncLanguages($hostLocale, Arr::get($defaultLocale, HostLocale::RELATION_LANGUAGES, []));
        }

        $otherLocales = Arr::get($attributes, Host::RELATION_OTHER_LOCALES, []);

        HostService::syncOtherLocales($host, $otherLocales);

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', ModelService::getSuccessMessage(Host::class, ModelEventEnum::CREATED));
    }

    #endregion
}
