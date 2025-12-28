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
use Narsil\Jobs\SitemapJob;
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
class HostUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Host $host
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Host $host): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $host);

        $data = $request->all();

        $rules = app(HostFormRequest::class)
            ->rules($host);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $host->update($attributes);

        if ($defaultLocale = Arr::get($attributes, Host::RELATION_DEFAULT_LOCALE))
        {
            $hostLocale = $host->{Host::RELATION_DEFAULT_LOCALE};

            $hostLocale->update([
                HostLocale::PATTERN  => Arr::get($defaultLocale, HostLocale::PATTERN),
            ]);

            HostLocaleService::syncLanguages($hostLocale, Arr::get($defaultLocale, HostLocale::RELATION_LANGUAGES, []));
        }

        HostService::syncOtherLocales($host, Arr::get($attributes, Host::RELATION_OTHER_LOCALES, []));

        SitemapJob::dispatch($host);

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', ModelService::getSuccessMessage(Host::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
