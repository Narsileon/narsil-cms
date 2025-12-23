<?php

namespace Narsil\Http\Controllers\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\TemplateFormRequest;
use Narsil\Enums\Database\EventEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Models\Elements\Template;
use Narsil\Services\MigrationService;
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
     * @param Request $request
     * @param Template $template
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, Template $template): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $template);

        $data = $request->all();

        $rules = app(TemplateFormRequest::class)
            ->rules($template);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $template->update($attributes);

        if (Arr::get($data, '_dirty', false))
        {
            TemplateService::syncTemplateSections($template, Arr::get($attributes, Template::RELATION_SECTIONS, []));

            MigrationService::syncTable($template);
        }

        return $this
            ->redirect(route('templates.index'))
            ->with('success', ModelService::getSuccessToast(Template::class, EventEnum::UPDATED));
    }

    #endregion
}
