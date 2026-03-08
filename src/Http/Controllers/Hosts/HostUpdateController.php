<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Contracts\Actions\Hosts\SyncHostLocales;
use Narsil\Cms\Contracts\Requests\HostFormRequest;
use Narsil\Cms\Jobs\SitemapJob;
use Narsil\Cms\Models\Hosts\Host;

#endregion

/**
 * @author Jonathan Rigaux
 */
class HostUpdateController extends RedirectController
{
    use HasSchemas;

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

        app(SyncHostLocales::class)
            ->run($host, [
                Arr::get($attributes, Host::RELATION_DEFAULT_LOCALE, []),
                ...Arr::get($attributes, Host::RELATION_OTHER_LOCALES, []),
            ]);

        SitemapJob::dispatch($host, $this->getCurrentSchema());

        return $this
            ->redirect(route('hosts.index'))
            ->with('success', ModelService::getSuccessMessage(Host::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
