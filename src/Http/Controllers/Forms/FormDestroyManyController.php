<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Forms\Form;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Form::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Form::query()
            ->whereIn(Form::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('forms.index'))
            ->with('success', trans('narsil::toasts.success.forms.deleted_many'));
    }

    #endregion
}
