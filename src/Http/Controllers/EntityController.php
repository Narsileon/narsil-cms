<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Narsil\Contracts\FormRequests\EntityFormRequest;
use Narsil\Contracts\Forms\EntityForm;
use Narsil\Contracts\Tables\EntityTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Template;
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
     * @param EntityFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(EntityFormRequest $formRequest)
    {
        $this->formRequest = $formRequest;

        $collection = request()->route('collection');

        Entity::$associatedTable = $collection;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var EntityFormRequest
     */
    protected readonly EntityFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $collection
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request, string $collection): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Entity::class);

        $template = Template::query()
            ->firstWhere(Template::HANDLE, '=', $collection);

        $query = Entity::query();

        $dataTable = new DataTableCollection($query, app()->make(EntityTable::class, [
            'collection' => $collection
        ]));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: $template->{Template::NAME},
            description: $template->{Template::NAME},
            props: [
                'dataTable' => $dataTable,
            ]
        );
    }

    /**
     * @param Request $request
     * @param string $collection
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request, string $collection): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $template = Template::query()
            ->firstWhere(Template::HANDLE, '=', $collection);

        $form = app()->make(EntityForm::class, [
            'template' => $template
        ]);

        $form->method = MethodEnum::POST;
        $form->url = route('collections.store', [
            'collection' => $collection
        ]);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     * @param string $collection
     *
     * @return RedirectResponse
     */
    public function store(Request $request, string $collection): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Entity::class);

        $data = $request->all();
        $rules = $this->formRequest->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $entity = Entity::create($attributes);

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]), $entity)
            ->with('success', trans('narsil::toasts.success.entities.created'));
    }

    /**
     * @param Request $request
     * @param string $collection
     * @param integer $id
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, string $collection, int $id): JsonResponse|Response
    {
        $entity = Entity::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $template = Template::query()
            ->firstWhere(Template::HANDLE, '=', $collection);

        $form = app()->make(EntityForm::class, [
            'template' => $template,
        ]);

        $form->method = MethodEnum::PATCH;
        $form->url = route('collections.update', [
            'id' => $entity->{Entity::ID},
            'collection' => $collection,
        ]);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($form->jsonSerialize(), [
                'data' => $entity,
            ]),
        );
    }

    /**
     * @param Request $request
     * @param string $collection
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, string $collection, int $id): RedirectResponse
    {
        $entity = Entity::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::UPDATE, $entity);

        $data = $request->all();
        $rules = $this->formRequest->rules($entity);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $entity->update($attributes);

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection
            ]), $entity)
            ->with('success', trans('narsil::toasts.success.entities.updated'));
    }

    /**
     * @param Request $request
     * @param string $collection
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, string $collection, int $id): RedirectResponse
    {
        $entity = Entity::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::DELETE, $entity);

        $entity->delete();

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]))
            ->with('success', trans('narsil::toasts.success.entities.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     * @param string $collection
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request, string $collection): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Entity::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Entity::query()
            ->whereIn(Entity::ID, $ids)
            ->delete();

        return $this
            ->redirect(route('collections.index'))
            ->with('success', trans('narsil::toasts.success.entities.deleted_many'));
    }

    #endregion
}
