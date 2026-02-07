<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Cms\Contracts\Requests\HostFormRequest;
use Narsil\Cms\Enums\ModelEventEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Jobs\SitemapJob;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Services\Models\HostLocaleService;
use Narsil\Cms\Services\Models\HostService;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param HostFormRequest $request
     * @param Host $host
     *
     * @return RedirectResponse
     */
    public function __invoke(HostFormRequest $request, Host $host): RedirectResponse
    {
        $attributes = $request->validated();

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
