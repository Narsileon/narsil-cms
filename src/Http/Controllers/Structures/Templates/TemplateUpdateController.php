<?php

namespace Narsil\Http\Controllers\Structures\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Contracts\FormRequests\TemplateFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Structures\Template;
use Narsil\Services\Models\TemplateService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateUpdateController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param TemplateFormRequest $request
     * @param Template $template
     *
     * @return RedirectResponse
     */
    public function __invoke(TemplateFormRequest $request, Template $template): RedirectResponse
    {
        $attributes = $request->validated();

        $template->update($attributes);

        TemplateService::syncTemplateTabs($template, Arr::get($attributes, Template::RELATION_TABS, []));

        return $this
            ->redirect(route('templates.index'))
            ->with('success', ModelService::getSuccessMessage(Template::class, ModelEventEnum::UPDATED));
    }

    #endregion
}
