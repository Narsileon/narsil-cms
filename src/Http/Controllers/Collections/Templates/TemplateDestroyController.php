<?php

namespace Narsil\Http\Controllers\Collections\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Collections\Template;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateDestroyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Template $template
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Template $template): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $template);

        $template->delete();

        return $this
            ->redirect(route('templates.index'))
            ->with('success', ModelService::getSuccessMessage(Template::class, ModelEventEnum::DELETED));
    }

    #endregion
}
