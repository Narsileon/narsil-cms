<?php

namespace Narsil\Http\Controllers\Structures\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\TemplateFormRequest;
use Narsil\Enums\ModelEventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Structures\Template;
use Narsil\Services\MigrationService;
use Narsil\Services\Models\TemplateService;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateStoreController extends RedirectController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Template::class);

        $data = $request->all();

        $rules = app(TemplateFormRequest::class)
            ->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $template = Template::create($attributes);

        TemplateService::syncTemplateSections($template, Arr::get($attributes, Template::RELATION_SECTIONS, []));

        MigrationService::syncTable($template);

        return $this
            ->redirect(route('templates.index'))
            ->with('success', ModelService::getSuccessMessage(Template::class, ModelEventEnum::CREATED));
    }

    #endregion
}
