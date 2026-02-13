<?php

namespace Narsil\Cms\Http\Controllers\Collections\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\ReplicateManyRequest;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Services\Models\TemplateService;
use Narsil\Cms\Services\ModelService;

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
            TemplateService::replicate($template);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Template::TABLE, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
