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
class TemplateStoreController extends AbstractController
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

        TemplateService::syncSections($template, Arr::get($attributes, Template::RELATION_SECTIONS, []));

        MigrationService::syncTable($template);

        return $this
            ->redirect(route('templates.index'))
            ->with('success', trans('narsil::toasts.success.templates.created'));
    }

    #endregion
}
