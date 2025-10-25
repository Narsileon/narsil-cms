<?php

namespace Narsil\Http\Controllers\Fields;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldDestroyController extends AbstractController
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
            ->with('success', trans('narsil::toasts.success.fields.deleted'));
    }

    #endregion
}
