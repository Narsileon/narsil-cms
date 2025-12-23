<?php

namespace Narsil\Http\Controllers\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Models\Elements\Template;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateDestroyManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Template::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Template::query()
            ->whereIn(Template::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('templates.index'))
            ->with('success', ModelService::getSuccessToast(Template::class, EventEnum::DELETED_MANY));
    }

    #endregion
}
