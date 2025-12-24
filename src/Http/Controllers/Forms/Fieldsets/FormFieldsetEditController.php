<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\FormFieldsetForm;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\Forms\FormFieldsetElement;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param FormFieldset $formFieldset
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, FormFieldset $formFieldset): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $formFieldset);

        $formFieldset->loadMissing([
            FormFieldset::RELATION_ELEMENTS . '.' . FormFieldsetElement::RELATION_ELEMENT,
        ]);

        $data = $this->getData($formFieldset);
        $form = $this->getForm($formFieldset);

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
     * @param FormFieldset $formfieldset
     *
     * @return array<string,mixed>
     */
    protected function getData(FormFieldset $formfieldset): array
    {
        $formfieldset->loadMissingCreatorAndEditor();

        $formfieldset->mergeCasts([
            FormFieldset::CREATED_AT => HumanDatetimeCast::class,
            FormFieldset::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $formfieldset->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(FormFieldset::class);
    }

    /**
     * Get the associated form.
     *
     * @param FormFieldset $formfieldset
     *
     * @return FormFieldsetForm
     */
    protected function getForm(FormFieldset $formfieldset): FormFieldsetForm
    {
        $form = app(FormFieldsetForm::class)
            ->action(route('form-fieldsets.update', $formfieldset->{FormFieldset::ID}))
            ->id($formfieldset->{FormFieldset::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(FormFieldset::class);
    }

    #endregion
}
