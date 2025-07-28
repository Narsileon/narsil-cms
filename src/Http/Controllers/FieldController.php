<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\FormRequests\FieldFormRequest;
use Narsil\Contracts\Forms\FieldForm;
use Narsil\Contracts\Tables\FieldTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractResourceController;
use Narsil\Http\Resources\DataTable\DataTableCollection;
use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldController extends AbstractResourceController
{
    #region CONSTRUCTOR

    /**
     * @param FieldForm $form
     * @param FieldFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(FieldForm $form, FieldFormRequest $formRequest)
    {
        $this->form = $form;
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var FieldForm
     */
    protected readonly FieldForm $form;
    /**
     * @var FieldFormRequest
     */
    protected readonly FieldFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $query = Field::query();

        $dataTable = new DataTableCollection($query, app(FieldTable::class));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil-cms::ui.fields'),
            description: trans('narsil-cms::ui.fields'),
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
            url: route('fields.store'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.create'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.field'),
            description: trans('narsil-cms::ui.field'),
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

        Field::create($attributes);

        return $this->redirectOnStored(Field::TABLE);
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Field $field): JsonResponse|Response
    {
        $form = $this->form->get(
            url: route('fields.update', $field->{Field::ID}),
            method: MethodEnum::PATCH,
            submit: trans('narsil-cms::ui.update'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.field'),
            description: trans('narsil-cms::ui.field'),
            props: [
                'data' => $field,
                'form' => $form,
            ]
        );
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Field $field): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        $field->update($attributes);

        return $this->redirectOnUpdated(Field::TABLE);
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Field $field): RedirectResponse
    {
        $field->delete();

        return $this->redirectOnDestroyed(Field::TABLE);
    }

    #endregion
}
