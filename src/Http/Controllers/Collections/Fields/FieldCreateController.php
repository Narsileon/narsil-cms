<?php

namespace Narsil\Http\Controllers\Collections\Fields;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\FieldForm;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Collections\Field;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldCreateController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Field::class);

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
        return ModelService::getModelLabel(Field::class);
    }

    /**
     * Get the associated form.
     *
     * @return FieldForm
     */
    protected function getForm(): FieldForm
    {
        $form = app(FieldForm::class)
            ->action(route('fields.store'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.save'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Field::class);
    }

    #endregion
}
