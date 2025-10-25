<?php

namespace Narsil\Http\Controllers\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldDestroyManyController extends AbstractController
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

        Field::whereIn(Field::ID, $ids)->delete();

        return $this
            ->redirect(route('fields.index'))
            ->with('success', trans('narsil::toasts.success.fields.deleted_many'));
    }

    #endregion
}
