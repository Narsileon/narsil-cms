<?php

namespace Narsil\Http\Controllers\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\ReplicateManyRequest;
use Narsil\Models\Elements\Template;
use Narsil\Services\Models\TemplateService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateReplicateManyController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Template::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $templates = Template::query()
            ->findMany($ids);

        foreach ($templates as $template)
        {
            TemplateService::replicateTemplate($template);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Template::class, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
