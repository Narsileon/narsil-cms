<?php

namespace Narsil\Http\Controllers\Configurations;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Contracts\FormRequests\ConfigurationFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Configuration;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfigurationUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param ConfigurationFormRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ConfigurationFormRequest $request): RedirectResponse
    {
        $configuration = Configuration::firstOrCreate();

        $this->authorize(PermissionEnum::UPDATE, $configuration);

        $attributes = $request->validated();

        $configuration->update($attributes);

        return back()
            ->with('success', ModelService::getSuccessMessage(Configuration::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
