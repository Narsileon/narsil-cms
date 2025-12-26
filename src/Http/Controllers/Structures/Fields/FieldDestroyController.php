<?php

namespace Narsil\Http\Controllers\Structures\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Structures\Field;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldDestroyController extends RedirectController
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
        $this->authorize(PermissionEnum::DELETE, $field);

        $field->delete();

        return $this
            ->redirect(route('fields.index'))
            ->with('success', ModelService::getSuccessMessage(Field::class, ModelEventEnum::DELETED));
    }

    #endregion
}
