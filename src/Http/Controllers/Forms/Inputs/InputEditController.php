<?php

namespace Narsil\Http\Controllers\Forms\Inputs;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\InputForm;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Forms\Input;
use Narsil\Models\ValidationRule;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class InputEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Input $input
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Input $input): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $input);

        if (!$request->has(Input::TYPE))
        {
            $request->merge([
                Input::TYPE => $input->{Input::TYPE},
            ]);
        }

        $this->transformValidationRules($input);

        $data = $this->getData($input);
        $form = $this->getForm($input);

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
     * @param Input $input
     *
     * @return array<string,mixed>
     */
    protected function getData(Input $input): array
    {
        $input->loadMissingCreatorAndEditor();

        $input->mergeCasts([
            Input::CREATED_AT => HumanDatetimeCast::class,
            Input::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $input->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Input::class);
    }

    /**
     * Get the associated form.
     *
     * @param Input $input
     *
     * @return InputForm
     */
    protected function getForm(Input $input): InputForm
    {
        $form = app(InputForm::class, ['model' => $input])
            ->action(route('inputs.update', $input->{Input::ID}))
            ->id($input->{Input::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Input::class);
    }

    /**
     * Transform the validation rules for the form.
     *
     * @param Input $input
     *
     * @return void
     */
    protected function transformValidationRules(Input $input): void
    {
        $validationRuleIds = $input->{Input::RELATION_VALIDATION_RULES}
            ->pluck(ValidationRule::ID)
            ->map(function ($id)
            {
                return (string)$id;
            });

        $input->setRelation(Input::RELATION_VALIDATION_RULES, $validationRuleIds);
    }

    #endregion
}
