<?php

namespace Narsil\Http\Controllers\Configurations;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\ConfigurationFormRequest;
use Narsil\Enums\Database\EventEnum;
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
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $configuration = Configuration::firstOrCreate();

        $this->authorize(PermissionEnum::UPDATE, $configuration);

        $data = $request->all();

        $rules = app(ConfigurationFormRequest::class)
            ->rules($configuration);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $configuration->update($attributes);

        return back()
            ->with('success', ModelService::getSuccessToast(Configuration::class, EventEnum::UPDATED));
    }

    #endregion
}
