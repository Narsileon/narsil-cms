<?php

namespace Narsil\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Forms\Input;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class InputDestroyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Input $input
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Input $input): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $input);

        $input->delete();

        return $this
            ->redirect(route('inputs.index'))
            ->with('success', ModelService::getSuccessMessage(Input::class, ModelEventEnum::DELETED));
    }

    #endregion
}
