<?php

namespace Narsil\Http\Controllers\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Elements\Template;
use Narsil\Services\Models\TemplateService;
use Narsil\Services\ModelService;

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

        TemplateService::replicateTemplate($template);

        return back()
            ->with('success', ModelService::getSuccessMessage(Template::class, ModelEventEnum::REPLICATED));
    }

    #endregion
}
