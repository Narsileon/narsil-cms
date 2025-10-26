<?php

namespace Narsil\Http\Controllers\Fields;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\FieldForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldCreateController extends AbstractController
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

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated form.
     *
     * @return FieldForm
     */
    protected function getForm(): FieldForm
    {
        $form = app(FieldForm::class)
            ->setAction(route('fields.store'))
            ->setMethod(MethodEnum::POST)
            ->setSubmitLabel(trans('narsil::ui.save'));

        return $form;
    }

    #endregion
}
