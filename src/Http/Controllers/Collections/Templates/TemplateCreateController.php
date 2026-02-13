<?php

namespace Narsil\Cms\Http\Controllers\Collections\Templates;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Contracts\Forms\TemplateForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateCreateController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Template::class);

        $form = $this->getForm();

        return $this->render('narsil/cms::resources/form', [
            'form' => $form,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Template::TABLE);
    }

    /**
     * Get the associated form.
     *
     * @return TemplateForm
     */
    protected function getForm(): TemplateForm
    {
        $form = app(TemplateForm::class)
            ->action(route('templates.store'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil-cms::ui.save'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Template::TABLE);
    }

    #endregion
}
