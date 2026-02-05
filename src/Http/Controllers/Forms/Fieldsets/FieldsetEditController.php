<?php

namespace Narsil\Cms\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Casts\HumanDatetimeCast;
use Narsil\Cms\Contracts\Forms\FieldsetForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\FieldsetElement;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Fieldset $fieldset
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Fieldset $fieldset): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $fieldset);

        $fieldset->loadMissing([
            Fieldset::RELATION_ELEMENTS . '.' . FieldsetElement::RELATION_BASE,
        ]);

        $data = $this->getData($fieldset);
        $form = $this->getForm($fieldset);

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
     * @param Fieldset $fieldset
     *
     * @return array<string,mixed>
     */
    protected function getData(Fieldset $fieldset): array
    {
        $fieldset->loadMissingCreatorAndEditor();

        $fieldset->mergeCasts([
            Fieldset::CREATED_AT => HumanDatetimeCast::class,
            Fieldset::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $fieldset->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Fieldset::class);
    }

    /**
     * Get the associated form.
     *
     * @param Fieldset $fieldset
     *
     * @return FieldsetForm
     */
    protected function getForm(Fieldset $fieldset): FieldsetForm
    {
        $form = app(FieldsetForm::class, ['model' => $fieldset])
            ->action(route('fieldsets.update', $fieldset->{Fieldset::ID}))
            ->id($fieldset->{Fieldset::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Fieldset::class);
    }

    #endregion
}
