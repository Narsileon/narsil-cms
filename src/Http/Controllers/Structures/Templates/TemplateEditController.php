<?php

namespace Narsil\Http\Controllers\Structures\Templates;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\TemplateForm;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Structures\Template;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Template $template
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Template $template): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $template);

        $data = $this->getData($template);
        $form = $this->getForm($template);

        return $this->render('narsil/cms::resources/form', [
            'data' => $data,
            'form' => $form,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @param Template $template
     *
     * @return array<string,mixed>
     */
    protected function getData(Template $template): array
    {
        $template->loadMissingCreatorAndEditor();

        $template->mergeCasts([
            Template::CREATED_AT => HumanDatetimeCast::class,
            Template::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $template->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Template::class);
    }

    /**
     * Get the associated form.
     *
     * @param Template $template
     *
     * @return TemplateForm
     */
    protected function getForm(Template $template): TemplateForm
    {
        $form = app(TemplateForm::class, ['model' => $template])
            ->action(route('templates.update', $template->{Template::ID}))
            ->id($template->{Template::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Template::class);
    }

    #endregion
}
