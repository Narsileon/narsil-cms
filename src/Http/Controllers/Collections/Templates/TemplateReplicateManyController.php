<?php

namespace Narsil\Cms\Http\Controllers\Collections\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Http\Requests\ReplicateManyRequest;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Templates\ReplicateTemplate;
use Narsil\Cms\Models\Collections\Template;

#endregion

/**
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
        $this->authorize(AbilityEnum::CREATE, Template::class);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $templates = Template::query()
            ->findMany($ids);

        foreach ($templates as $template)
        {
            app(ReplicateTemplate::class)
                ->run($template);
        }

        return back()
            ->with('success', ModelService::getSuccessMessage(Template::TABLE, ModelEventEnum::REPLICATED_MANY));
    }

    #endregion
}
