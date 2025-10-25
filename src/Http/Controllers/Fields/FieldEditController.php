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
class FieldEditController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Field $field): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $field);

        if (!$request->has(Field::TYPE))
        {
            $request->merge([
                Field::TYPE => $field->{Field::TYPE},
            ]);
        }

        $form = app(FieldForm::class)
            ->setAction(route('fields.update', $field->{Field::ID}))
            ->setData($field->toArrayWithTranslations())
            ->setId($field->{Field::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion
}
