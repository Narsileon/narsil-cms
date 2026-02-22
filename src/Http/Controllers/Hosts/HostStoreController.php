<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Requests\HostFormRequest;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Services\HostLocaleService;
use Narsil\Cms\Services\HostService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param HostFormRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(HostFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $host = Host::create($attributes);

        if ($defaultLocale = Arr::get($attributes, Host::RELATION_DEFAULT_LOCALE))
        {
            $hostLocale = HostLocale::create([
                HostLocale::HOST_ID  => $host->id,
                HostLocale::PATTERN  => Arr::get($defaultLocale, HostLocale::PATTERN),
            ]);

            HostLocaleService::syncLanguages($hostLocale, Arr::get($defaultLocale, HostLocale::RELATION_LANGUAGES, []));
        }

        HostService::syncOtherLocales($host, Arr::get($attributes, Host::RELATION_OTHER_LOCALES, []));

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', ModelService::getSuccessMessage(Host::TABLE, ModelEventEnum::CREATED));
    }

    #endregion
}
