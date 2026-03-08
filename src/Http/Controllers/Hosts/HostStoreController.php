<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocales;
use Narsil\Cms\Contracts\Requests\HostFormRequest;
use Narsil\Cms\Models\Hosts\Host;
#endregion

/**
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

        app(SyncHostLocales::class)
            ->run($host, [
                Arr::get($attributes, Host::RELATION_DEFAULT_LOCALE, []),
                ...Arr::get($attributes, Host::RELATION_OTHER_LOCALES, []),
            ]);

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', ModelService::getSuccessMessage(Host::TABLE, ModelEventEnum::CREATED));
    }

    #endregion
}
