<?php

namespace Narsil\Cms\Http\Controllers\Collections\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Services\ModelService;

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
            ->with('success', ModelService::getSuccessMessage(Template::class, ModelEventEnum::DELETED_MANY));
    }

    #endregion
}
