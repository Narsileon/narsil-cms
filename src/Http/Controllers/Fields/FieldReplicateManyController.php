<?php

namespace Narsil\Http\Controllers\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Elements\Field;
use Narsil\Services\FieldService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldReplicateManyController extends AbstractController
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
            ->with('success', trans('narsil::toasts.success.fields.replicated_many'));
    }

    #endregion
}
