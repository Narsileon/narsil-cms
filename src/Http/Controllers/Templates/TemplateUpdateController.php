<?php

namespace Narsil\Http\Controllers\Templates;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Narsil\Contracts\FormRequests\TemplateFormRequest;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Elements\Template;
use Narsil\Services\MigrationService;
use Narsil\Services\TemplateService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateUpdateController extends AbstractController
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

        $rules = app(TemplateFormRequest::class)->rules($template);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $template->update($attributes);

        if (Arr::get($data, '_dirty', false))
        {
            TemplateService::syncSections($template, Arr::get($attributes, Template::RELATION_SECTIONS, []));

            if ($sets = Arr::get($attributes, Template::RELATION_SETS))
            {
                TemplateService::syncSets($template, $sets);
            }

            MigrationService::syncTable($template);
        }

        return $this
            ->redirect(route('templates.index'))
            ->with('success', trans('narsil::toasts.success.templates.updated'));
    }

    #endregion
}
