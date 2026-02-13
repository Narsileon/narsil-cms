<?php

namespace Narsil\Cms\Http\Controllers\Collections\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Field::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Field::query()
            ->whereIn(Field::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('fields.index'))
            ->with('success', ModelService::getSuccessMessage(Field::TABLE, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
