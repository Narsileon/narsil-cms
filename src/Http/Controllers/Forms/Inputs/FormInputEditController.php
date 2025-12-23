<?php

namespace Narsil\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\FormInputForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Forms\FormInput;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param FormInput $formInput
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, FormInput $formInput): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $formInput);

        if (!$request->has(FormInput::TYPE))
        {
            $request->merge([
                FormInput::TYPE => $formInput->{FormInput::TYPE},
            ]);
        }

        $data = $this->getData($formInput);
        $form = $this->getForm($formInput);

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
     * @param FormInput $input
     *
     * @return array<string,mixed>
     */
    protected function getData(FormInput $input): array
    {
        $input->loadMissingCreatorAndEditor();

        $input->mergeCasts([
            FormInput::CREATED_AT => HumanDatetimeCast::class,
            FormInput::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $input->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(FormInput::class);
    }

    /**
     * Get the associated form.
     *
     * @param FormInput $input
     *
     * @return FormInputForm
     */
    protected function getForm(FormInput $input): FormInputForm
    {
        $form = app(FormInputForm::class)
            ->action(route('form-inputs.update', $input->{FormInput::ID}))
            ->id($input->{FormInput::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(FormInput::class);
    }

    #endregion
}
