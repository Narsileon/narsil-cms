<?php

namespace Narsil\Cms\Http\Controllers\Collections\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabs;
use Narsil\Cms\Contracts\Requests\TemplateFormRequest;
use Narsil\Cms\Models\Collections\Template;

#endregion

/**
 * @author Jonathan Rigaux
 */
class TemplateStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param TemplateFormRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(TemplateFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        $template = Template::create($attributes);

        app(SyncTemplateTabs::class)
            ->run($template, Arr::get($attributes, Template::RELATION_TABS, []));

        return $this
            ->redirect(route('templates.index'))
            ->with('success', ModelService::getSuccessMessage(Template::TABLE, ModelEventEnum::CREATED));
    }

    #endregion
}
