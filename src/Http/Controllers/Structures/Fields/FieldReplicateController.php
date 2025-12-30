<?php

namespace Narsil\Http\Controllers\Structures\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Structures\Field;
use Narsil\Services\Models\FieldService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldReplicateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Field $field): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Field::class);

        FieldService::replicate($field);

        return back()
            ->with('success', ModelService::getSuccessMessage(Field::class, ModelEventEnum::REPLICATED));
    }

    #endregion
}
