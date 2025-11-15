<?php

namespace Narsil\Http\Controllers\Fields;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\FieldForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldEditController extends RenderController
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

        $data = $this->getData($field);
        $form = $this->getForm($field);

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
     * @param Field $field
     *
     * @return array<string,mixed>
     */
    protected function getData(Field $field): array
    {
        $field->loadMissingCreatorAndEditor();

        $field->mergeCasts([
            Field::CREATED_AT => HumanDatetimeCast::class,
            Field::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $field->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::models.' . Field::class);
    }

    /**
     * Get the associated form.
     *
     * @param Field $field
     *
     * @return FieldForm
     */
    protected function getForm(Field $field): FieldForm
    {
        $form = app(FieldForm::class)
            ->action(route('fields.update', $field->{Field::ID}))
            ->id($field->{Field::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::models.' . Field::class);
    }

    #endregion
}
