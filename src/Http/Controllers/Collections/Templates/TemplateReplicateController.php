<?php

namespace Narsil\Cms\Http\Controllers\Collections\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Services\Models\TemplateService;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateReplicateController extends RedirectController
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
        $this->authorize(PermissionEnum::CREATE, Template::class);

        TemplateService::replicate($template);

        return back()
            ->with('success', ModelService::getSuccessMessage(Template::class, ModelEventEnum::REPLICATED));
    }

    #endregion
}
