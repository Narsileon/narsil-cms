<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\FormRequests\FieldSetFormRequest;
use Narsil\Contracts\Forms\FieldSetForm;
use Narsil\Contracts\Tables\FieldSetTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractResourceController;
use Narsil\Http\Resources\DataTable\DataTableCollection;
use Narsil\Models\Fields\FieldSet;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldSetController extends AbstractResourceController
{
    #region CONSTRUCTOR

    /**
     * @param FieldSetForm $form
     * @param FieldSetFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(FieldSetForm $form, FieldSetFormRequest $formRequest)
    {
        $this->form = $form;
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var FieldSetForm
     */
    protected readonly FieldSetForm $form;
    /**
     * @var FieldSetFormRequest
     */
    protected readonly FieldSetFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $query = FieldSet::query()
            ->with([
                FieldSet::RELATION_FIELDS,
                FieldSet::RELATION_FIELD_SETS,
            ])
            ->withCount([
                FieldSet::RELATION_FIELDS,
                FieldSet::RELATION_FIELD_SETS,
            ]);

        $dataTable = new DataTableCollection($query, app(FieldSetTable::class));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil-cms::ui.field_sets'),
            description: trans('narsil-cms::ui.field_sets'),
            props: [
                'dataTable' => $dataTable,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request): JsonResponse|Response
    {
        $form = $this->form->get(
            url: route('field-sets.store'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.create'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.field_set'),
            description: trans('narsil-cms::ui.field_set'),
            props: [
                'form' => $form,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        $fieldSet = FieldSet::create($attributes);

        return $this->redirectOnStored(FieldSet::TABLE, $fieldSet);
    }

    /**
     * @param Request $request
     * @param FieldSet $field
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, FieldSet $fieldSet): JsonResponse|Response
    {
        $form = $this->form->get(
            url: route('field-sets.update', $fieldSet->{FieldSet::ID}),
            method: MethodEnum::PATCH,
            submit: trans('narsil-cms::ui.update'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.field_set'),
            description: trans('narsil-cms::ui.field_set'),
            props: [
                'data' => $fieldSet,
                'form' => $form,
            ]
        );
    }

    /**
     * @param Request $request
     * @param FieldSet $fieldSet
     *
     * @return RedirectResponse
     */
    public function update(Request $request, FieldSet $fieldSet): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        $fieldSet->update($attributes);

        return $this->redirectOnUpdated(FieldSet::TABLE, $fieldSet);
    }

    /**
     * @param Request $request
     * @param FieldSet $fieldSet
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, FieldSet $fieldSet): RedirectResponse
    {
        $fieldSet->delete();

        return $this->redirectOnDestroyed(FieldSet::TABLE);
    }

    #endregion
}
