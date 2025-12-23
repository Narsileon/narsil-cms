<?php

namespace Narsil\Http\Controllers\Forms;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\FormForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Forms\Form;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Form $form
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Form $form): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $form);

        $data = $this->getData($form);
        $form = $this->getForm($form);

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
     * @param Form $form
     *
     * @return array<string,mixed>
     */
    protected function getData(Form $form): array
    {
        $form->loadMissingCreatorAndEditor();

        $form->mergeCasts([
            Form::CREATED_AT => HumanDatetimeCast::class,
            Form::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $form->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Form::class);
    }

    /**
     * Get the associated form.
     *
     * @param Form $form
     *
     * @return FormForm
     */
    protected function getForm(Form $form): FormForm
    {
        $form = app(FormForm::class)
            ->action(route('forms.update', $form->{Form::ID}))
            ->id($form->{Form::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Form::class);
    }

    #endregion
}
