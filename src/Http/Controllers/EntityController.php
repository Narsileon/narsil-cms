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
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Field;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityController extends AbstractController
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
        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $this->form->jsonSerialize(),
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

        $entity = Entity::create($attributes);

        return $this
            ->redirect(route('entities.index'), $entity)
            ->with('success', trans('narsil-cms::toasts.success.entities.created'));
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Field $field): JsonResponse|Response
    {
        $this->form
            ->method(MethodEnum::PATCH)
            ->submit(trans('narsil-cms::ui.update'))
            ->url(route('entities.update', $field->{Field::ID}));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($this->form->jsonSerialize(), [
                'data' => $field,
            ]),
        );
    }

    /**
     * @param Request $request
     * @param Entity $field
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Entity $entity): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        $entity->update($attributes);

        return $this
            ->redirect(route('entities.index'), $entity)
            ->with('success', trans('narsil-cms::toasts.success.entities.updated'));
    }

    /**
     * @param Request $request
     * @param Entity $entity
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Entity $entity): RedirectResponse
    {
        $entity->delete();

        return $this
            ->redirect(route('entities.index'))
            ->with('success', trans('narsil-cms::toasts.success.entities.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $ids = $request->validated(DestroyManyRequest::IDS);

        Entity::whereIn(Entity::ID, $ids)->delete();

        return $this
            ->redirect(route('entities.index'))
            ->with('success', trans('narsil-cms::toasts.success.entities.deleted_many'));
    }

    #endregion
}
