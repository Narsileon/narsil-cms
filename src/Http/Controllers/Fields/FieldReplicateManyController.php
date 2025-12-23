<?php

namespace Narsil\Http\Controllers\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Elements\Field;
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
            FieldService::replicateField($field);
        }

        return back()
            ->with('success', ModelService::getSuccessToast(Field::class, EventEnum::REPLICATED_MANY));
    }

    #endregion
}
