<?php

namespace Narsil\Http\Controllers\Structures\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Structures\Field;
use Narsil\Services\Models\FieldService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldReplicateManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Field::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $fields = Field::query()
            ->findMany($ids);

        foreach ($fields as $field)
        {
            FieldService::replicate($field);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Field::class, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
