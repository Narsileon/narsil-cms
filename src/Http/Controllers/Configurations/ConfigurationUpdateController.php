<?php

namespace Narsil\Cms\Http\Controllers\Configurations;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Requests\ConfigurationFormRequest;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Configuration;

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

        $this->authorize(AbilityEnum::UPDATE, $configuration);

        $attributes = $request->validated();

        $configuration->update($attributes);

        return back()
            ->with('success', ModelService::getSuccessMessage(Configuration::TABLE, ModelEventEnum::UPDATED));
    }

    #endregion
}
