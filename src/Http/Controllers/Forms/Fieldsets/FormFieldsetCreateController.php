<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\FormFieldsetForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Forms\FormFieldset;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetCreateController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, FormFieldset::class);

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
        return trans('narsil::models.' . FormFieldset::class);
    }

    /**
     * Get the associated form.
     *
     * @return FormFieldsetForm
     */
    protected function getForm(): FormFieldsetForm
    {
        $form = app(FormFieldsetForm::class)
            ->action(route('form-fieldsets.store'))
            ->method(MethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.save'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::models.' . FormFieldset::class);
    }

    #endregion
}
