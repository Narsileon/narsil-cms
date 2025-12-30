<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Forms\Form;
use Narsil\Services\Models\FormService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormReplicateManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Form::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $forms = Form::query()
            ->findMany($ids);

        foreach ($forms as $form)
        {
            FormService::replicate($form);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Form::class, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
